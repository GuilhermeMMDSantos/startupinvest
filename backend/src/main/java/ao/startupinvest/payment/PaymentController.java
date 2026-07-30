package ao.startupinvest.payment;

import ao.startupinvest.investment.Investment;
import ao.startupinvest.investment.InvestmentService;
import ao.startupinvest.investment.dto.InvestmentDto;
import ao.startupinvest.payment.dto.CreatePaymentOrderRequest;
import ao.startupinvest.security.SecurityUser;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.*;

import java.util.Map;

@RestController
@RequestMapping("/api/investments/{investmentId}/payment")
@RequiredArgsConstructor
public class PaymentController {

    private final PaymentService paymentService;
    private final InvestmentService investmentService;

    @PostMapping("/create")
    public Map<String, String> create(@PathVariable Long investmentId, @RequestBody CreatePaymentOrderRequest request,
                                       @AuthenticationPrincipal SecurityUser user) {
        Investment investment = investmentService.getOwnedByInvestor(investmentId, user.getId());
        String approveUrl = paymentService.createDepositOrder(investment, request.returnUrl(), request.cancelUrl());
        return Map.of("approveUrl", approveUrl);
    }

    @PostMapping("/capture")
    public InvestmentDto capture(@PathVariable Long investmentId, @RequestParam String orderId,
                                  @AuthenticationPrincipal SecurityUser user) {
        Investment investment = investmentService.getOwnedByInvestor(investmentId, user.getId());
        return InvestmentDto.from(paymentService.captureDeposit(investment, orderId));
    }
}
