package ao.startupinvest.investment;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.contract.Contract;
import ao.startupinvest.contract.ContractService;
import ao.startupinvest.contract.SignerRole;
import ao.startupinvest.investor.InvestorProfile;
import ao.startupinvest.investor.InvestorProfileRepository;
import ao.startupinvest.investor.VerificationStatus;
import ao.startupinvest.payment.PaymentService;
import ao.startupinvest.round.FundingRound;
import ao.startupinvest.round.FundingRoundRepository;
import ao.startupinvest.round.RoundMathService;
import ao.startupinvest.round.RoundStatus;
import ao.startupinvest.security.SecurityUser;
import ao.startupinvest.user.UserRole;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;
import java.util.List;

@Service
@RequiredArgsConstructor
public class InvestmentService {

    private static final List<InvestmentStatus> ACTIVE_STATUSES = List.of(
            InvestmentStatus.PENDING_PAYMENT, InvestmentStatus.PAID, InvestmentStatus.CONTRACT_PENDING,
            InvestmentStatus.CONTRACT_SIGNED, InvestmentStatus.CONFIRMED);

    private final InvestmentRepository investmentRepository;
    private final FundingRoundRepository fundingRoundRepository;
    private final InvestorProfileRepository investorProfileRepository;
    private final RoundMathService roundMathService;
    private final ContractService contractService;
    private final PaymentService paymentService;

    @Transactional
    public Investment createIntent(SecurityUser user, Long roundId, BigDecimal amount) {
        InvestorProfile investor = investorProfileRepository.findByUserId(user.getId())
                .orElseThrow(() -> ApiException.badRequest("Perfil de investidor não encontrado"));
        if (investor.getVerificationStatus() != VerificationStatus.APPROVED) {
            throw ApiException.forbidden("A sua conta de investidor ainda não foi verificada pelo administrador");
        }
        FundingRound round = fundingRoundRepository.findByIdForUpdate(roundId)
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));

        long activeInvestors = investmentRepository.countByRoundIdAndStatusIn(roundId, ACTIVE_STATUSES);
        roundMathService.validateInvestmentAmount(round, amount, activeInvestors);

        Investment investment = new Investment();
        investment.setRound(round);
        investment.setInvestor(investor);
        investment.setAmount(amount);
        investment.setEquityPctAllocated(roundMathService.computeEquityAllocation(amount, round.getTargetAmount(), round.getEquityOfferedPct()));
        investment.setStatus(InvestmentStatus.PENDING_PAYMENT);
        return investmentRepository.save(investment);
    }

    public Investment getOwnedByInvestor(Long investmentId, Long userId) {
        Investment investment = investmentRepository.findById(investmentId)
                .orElseThrow(() -> ApiException.notFound("Investimento não encontrado"));
        if (!investment.getInvestor().getUser().getId().equals(userId)) {
            throw ApiException.forbidden("Este investimento não lhe pertence");
        }
        return investment;
    }

    public Investment getVisible(Long investmentId, SecurityUser user) {
        Investment investment = investmentRepository.findById(investmentId)
                .orElseThrow(() -> ApiException.notFound("Investimento não encontrado"));
        boolean isInvestor = investment.getInvestor().getUser().getId().equals(user.getId());
        boolean isStartupOwner = investment.getRound().getStartup().getOwner().getId().equals(user.getId());
        boolean isAdmin = user.getUser().getRole() == UserRole.ADMIN;
        if (!isInvestor && !isStartupOwner && !isAdmin) {
            throw ApiException.forbidden("Sem acesso a este investimento");
        }
        return investment;
    }

    public List<Investment> listMine(SecurityUser user) {
        InvestorProfile investor = investorProfileRepository.findByUserId(user.getId())
                .orElseThrow(() -> ApiException.badRequest("Perfil de investidor não encontrado"));
        return investmentRepository.findByInvestorId(investor.getId());
    }

    public List<Investment> listForRound(Long roundId) {
        return investmentRepository.findByRoundId(roundId);
    }

    @Transactional
    public Contract signContract(SecurityUser user, Long contractId, String fullNameTyped, String ipAddress) {
        Contract contract = contractService.getById(contractId);
        Investment investment = contract.getInvestment();
        SignerRole role = resolveRole(user, investment);

        Contract signed = contractService.sign(contractId, user.getUser(), role, fullNameTyped, ipAddress);

        if (role == SignerRole.INVESTOR) {
            investment.setStatus(InvestmentStatus.CONTRACT_SIGNED);
            investmentRepository.save(investment);
        }

        if (signed.getStatus() == ao.startupinvest.contract.ContractStatus.FULLY_SIGNED) {
            investment.setStatus(InvestmentStatus.CONFIRMED);
            investmentRepository.save(investment);
            checkRoundCompletion(investment.getRound().getId());
        }

        return signed;
    }

    private SignerRole resolveRole(SecurityUser user, Investment investment) {
        if (user.getUser().getRole() == UserRole.INVESTOR
                && investment.getInvestor().getUser().getId().equals(user.getId())) {
            return SignerRole.INVESTOR;
        }
        if (user.getUser().getRole() == UserRole.STARTUP_OWNER
                && investment.getRound().getStartup().getOwner().getId().equals(user.getId())) {
            return SignerRole.STARTUP;
        }
        throw ApiException.forbidden("Não tem permissão para assinar este contrato");
    }

    private void checkRoundCompletion(Long roundId) {
        FundingRound round = fundingRoundRepository.findByIdForUpdate(roundId)
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));
        if (round.getAmountRaised().compareTo(round.getTargetAmount()) < 0) {
            return;
        }
        List<Investment> active = investmentRepository.findByRoundId(roundId).stream()
                .filter(i -> i.getStatus() != InvestmentStatus.CANCELLED && i.getStatus() != InvestmentStatus.REFUNDED)
                .toList();
        if (active.isEmpty()) {
            return;
        }
        boolean allConfirmed = active.stream().allMatch(i -> i.getStatus() == InvestmentStatus.CONFIRMED);
        if (allConfirmed && round.getStatus() != RoundStatus.CLOSED_SUCCESS) {
            paymentService.payoutToStartup(round);
        }
    }
}
