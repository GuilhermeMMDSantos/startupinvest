package ao.startupinvest.contract;

import ao.startupinvest.contract.dto.ContractDto;
import ao.startupinvest.contract.dto.SignContractRequest;
import ao.startupinvest.investment.InvestmentService;
import ao.startupinvest.security.SecurityUser;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.*;

@RestController
@RequiredArgsConstructor
public class ContractController {

    private final ContractService contractService;
    private final InvestmentService investmentService;

    @GetMapping("/api/investments/{investmentId}/contract")
    public ContractDto getForInvestment(@PathVariable Long investmentId, @AuthenticationPrincipal SecurityUser user) {
        investmentService.getVisible(investmentId, user);
        return ContractDto.from(contractService.getForInvestment(investmentId));
    }

    @GetMapping("/api/contracts/{id}")
    public ContractDto get(@PathVariable Long id, @AuthenticationPrincipal SecurityUser user) {
        Contract contract = contractService.getById(id);
        investmentService.getVisible(contract.getInvestment().getId(), user);
        return ContractDto.from(contract);
    }

    @PostMapping("/api/contracts/{id}/sign")
    public ContractDto sign(@PathVariable Long id, @Valid @RequestBody SignContractRequest request,
                             @AuthenticationPrincipal SecurityUser user, HttpServletRequest servletRequest) {
        Contract contract = investmentService.signContract(user, id, request.fullNameTyped(), servletRequest.getRemoteAddr());
        return ContractDto.from(contract);
    }
}
