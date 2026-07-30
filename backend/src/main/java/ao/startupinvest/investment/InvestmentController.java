package ao.startupinvest.investment;

import ao.startupinvest.investment.dto.CreateInvestmentRequest;
import ao.startupinvest.investment.dto.InvestmentDto;
import ao.startupinvest.round.RoundService;
import ao.startupinvest.security.SecurityUser;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequiredArgsConstructor
public class InvestmentController {

    private final InvestmentService investmentService;
    private final RoundService roundService;

    @PostMapping("/api/rounds/{roundId}/investments")
    public InvestmentDto create(@PathVariable Long roundId, @RequestBody CreateInvestmentRequest request,
                                 @AuthenticationPrincipal SecurityUser user) {
        return InvestmentDto.from(investmentService.createIntent(user, roundId, request.amount()));
    }

    @GetMapping("/api/investments/mine")
    public List<InvestmentDto> mine(@AuthenticationPrincipal SecurityUser user) {
        return investmentService.listMine(user).stream().map(InvestmentDto::from).toList();
    }

    @GetMapping("/api/investments/{id}")
    public InvestmentDto get(@PathVariable Long id, @AuthenticationPrincipal SecurityUser user) {
        return InvestmentDto.from(investmentService.getVisible(id, user));
    }

    @GetMapping("/api/rounds/{roundId}/investments")
    public List<InvestmentDto> forRound(@PathVariable Long roundId, @AuthenticationPrincipal SecurityUser user) {
        roundService.getOwnedRound(user.getId(), roundId);
        return investmentService.listForRound(roundId).stream().map(InvestmentDto::from).toList();
    }
}
