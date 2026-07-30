package ao.startupinvest.payment;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.config.AppProperties;
import ao.startupinvest.contract.Contract;
import ao.startupinvest.contract.ContractService;
import ao.startupinvest.investment.Investment;
import ao.startupinvest.investment.InvestmentRepository;
import ao.startupinvest.investment.InvestmentStatus;
import ao.startupinvest.notification.NotificationService;
import ao.startupinvest.round.FundingRound;
import ao.startupinvest.round.FundingRoundRepository;
import ao.startupinvest.round.RoundStatus;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;

@Service
@RequiredArgsConstructor
public class PaymentService {

    private final PayPalClient payPalClient;
    private final PaymentRepository paymentRepository;
    private final PayoutRepository payoutRepository;
    private final InvestmentRepository investmentRepository;
    private final FundingRoundRepository fundingRoundRepository;
    private final ContractService contractService;
    private final NotificationService notificationService;
    private final AppProperties appProperties;

    @Transactional
    public String createDepositOrder(Investment investment, String returnUrl, String cancelUrl) {
        if (investment.getStatus() != InvestmentStatus.PENDING_PAYMENT) {
            throw ApiException.badRequest("Este investimento já não está pendente de pagamento");
        }
        String currency = appProperties.getPaypal().getCurrency();
        PayPalClient.OrderResult result = payPalClient.createOrder(investment.getAmount(), currency, returnUrl, cancelUrl);

        Payment payment = new Payment();
        payment.setInvestment(investment);
        payment.setType(PaymentType.DEPOSIT);
        payment.setProviderOrderId(result.orderId());
        payment.setAmount(investment.getAmount());
        payment.setCurrency(currency);
        payment.setStatus(PaymentStatus.CREATED);
        payment.setRawResponse(result.rawResponse());
        paymentRepository.save(payment);

        return result.approveUrl();
    }

    @Transactional
    public Investment captureDeposit(Investment investment, String orderId) {
        Payment payment = paymentRepository.findByProviderOrderId(orderId)
                .orElseThrow(() -> ApiException.notFound("Pagamento não encontrado para esta ordem"));
        if (!payment.getInvestment().getId().equals(investment.getId())) {
            throw ApiException.forbidden("Esta ordem de pagamento não pertence a este investimento");
        }
        if (payment.getStatus() == PaymentStatus.COMPLETED) {
            return investment;
        }

        PayPalClient.CaptureResult capture = payPalClient.captureOrder(orderId);
        payment.setRawResponse(capture.rawResponse());
        if (!capture.completed()) {
            payment.setStatus(PaymentStatus.FAILED);
            paymentRepository.save(payment);
            throw ApiException.badRequest("O PayPal não confirmou a captura do pagamento");
        }
        payment.setStatus(PaymentStatus.COMPLETED);
        paymentRepository.save(payment);

        FundingRound round = fundingRoundRepository.findByIdForUpdate(investment.getRound().getId())
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));
        round.setAmountRaised(round.getAmountRaised().add(investment.getAmount()));
        if (round.getAmountRaised().compareTo(round.getTargetAmount()) >= 0) {
            round.setStatus(RoundStatus.CONTRACTS_PENDING);
        }
        fundingRoundRepository.save(round);

        investment.setStatus(InvestmentStatus.PAID);
        investment = investmentRepository.save(investment);

        Contract contract = contractService.createForInvestment(investment);
        investment.setStatus(InvestmentStatus.CONTRACT_PENDING);
        investment = investmentRepository.save(investment);

        notificationService.notify(round.getStartup().getOwner(), "INVESTMENT_RECEIVED", "Novo investimento recebido",
                investment.getInvestor().getFullName() + " investiu " + investment.getAmount() + " na sua rodada. Assine o contrato para libertar os fundos.");
        notificationService.notify(investment.getInvestor().getUser(), "PAYMENT_CONFIRMED", "Pagamento confirmado",
                "O seu investimento de " + investment.getAmount() + " foi confirmado. Assine o contrato gerado (nº " + contract.getId() + ").");

        return investment;
    }

    @Transactional
    public Payout payoutToStartup(FundingRound round) {
        var existing = payoutRepository.findByRoundId(round.getId());
        if (existing.isPresent()) {
            return existing.get();
        }
        String startupEmail = round.getStartup().getPaypalPayoutEmail();
        if (startupEmail == null || startupEmail.isBlank()) {
            throw ApiException.badRequest("A startup não configurou o email de recebimento PayPal");
        }
        String currency = appProperties.getPaypal().getCurrency();

        Payout payout = new Payout();
        payout.setRound(round);
        payout.setAmount(round.getAmountRaised());
        payout.setStatus(PayoutStatus.PROCESSING);
        payout = payoutRepository.save(payout);

        try {
            PayPalClient.PayoutResult result = payPalClient.sendPayout(startupEmail, round.getAmountRaised(), currency,
                    "Libertação de fundos da rodada #" + round.getId(), "round-" + round.getId() + "-" + System.currentTimeMillis());
            payout.setProviderPayoutBatchId(result.batchId());
            payout.setStatus(PayoutStatus.COMPLETED);
            payout = payoutRepository.save(payout);

            Payment payment = new Payment();
            payment.setPayout(payout);
            payment.setType(PaymentType.PAYOUT);
            payment.setAmount(round.getAmountRaised());
            payment.setCurrency(currency);
            payment.setStatus(PaymentStatus.COMPLETED);
            payment.setRawResponse(result.rawResponse());
            paymentRepository.save(payment);
        } catch (Exception e) {
            payout.setStatus(PayoutStatus.FAILED);
            payoutRepository.save(payout);
            throw e;
        }

        round.setStatus(RoundStatus.CLOSED_SUCCESS);
        round.setClosedAt(java.time.Instant.now());
        fundingRoundRepository.save(round);

        notificationService.notify(round.getStartup().getOwner(), "PAYOUT_COMPLETED", "Fundos libertados",
                "Os fundos da rodada (" + round.getAmountRaised() + ") foram transferidos para a sua conta.");

        return payout;
    }
}
