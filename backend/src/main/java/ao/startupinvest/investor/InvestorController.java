package ao.startupinvest.investor;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.investor.dto.InvestorProfileDto;
import ao.startupinvest.security.SecurityUser;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api/investors")
@RequiredArgsConstructor
public class InvestorController {

    private final InvestorProfileRepository investorProfileRepository;

    @GetMapping("/me")
    public InvestorProfileDto me(@AuthenticationPrincipal SecurityUser user) {
        InvestorProfile profile = investorProfileRepository.findByUserId(user.getId())
                .orElseThrow(() -> ApiException.notFound("Perfil de investidor não encontrado"));
        return InvestorProfileDto.from(profile);
    }
}
