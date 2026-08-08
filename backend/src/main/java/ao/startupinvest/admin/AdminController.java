package ao.startupinvest.admin;

import ao.startupinvest.admin.dto.AdminStatsDto;
import ao.startupinvest.admin.dto.DecisionRequest;
import ao.startupinvest.admin.dto.UserStatusRequest;
import ao.startupinvest.contract.dto.ContractDto;
import ao.startupinvest.investment.dto.InvestmentDto;
import ao.startupinvest.investor.VerificationStatus;
import ao.startupinvest.investor.dto.InvestorProfileDto;
import ao.startupinvest.payment.dto.PaymentDto;
import ao.startupinvest.round.dto.RoundDto;
import ao.startupinvest.scoring.ScoringResultRepository;
import ao.startupinvest.security.SecurityUser;
import ao.startupinvest.startup.StartupStatus;
import ao.startupinvest.startup.dto.StartupDto;
import ao.startupinvest.user.UserRole;
import ao.startupinvest.user.UserStatus;
import ao.startupinvest.user.dto.UserSummaryDto;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/admin")
@RequiredArgsConstructor
@Transactional
public class AdminController {

    private final AdminService adminService;
    private final ScoringResultRepository scoringResultRepository;

    @GetMapping("/investors")
    public List<InvestorProfileDto> investors(@RequestParam(required = false) VerificationStatus status) {
        return adminService.listInvestors(status).stream().map(InvestorProfileDto::from).toList();
    }

    @PostMapping("/investors/{id}/decision")
    public InvestorProfileDto decideInvestor(@PathVariable Long id, @Valid @RequestBody DecisionRequest request,
                                              @AuthenticationPrincipal SecurityUser admin) {
        return InvestorProfileDto.from(adminService.decideInvestor(admin.getId(), id, request.approve(), request.notes()));
    }

    @GetMapping("/startups")
    public List<StartupDto> startups(@RequestParam(required = false) StartupStatus status) {
        return adminService.listStartups(status).stream().map(StartupDto::from).toList();
    }

    @PostMapping("/startups/{id}/decision")
    public StartupDto decideStartup(@PathVariable Long id, @Valid @RequestBody DecisionRequest request,
                                     @AuthenticationPrincipal SecurityUser admin) {
        return StartupDto.from(adminService.decideStartup(admin.getId(), id, request.approve(), request.notes()));
    }

    @GetMapping("/rounds")
    public List<RoundDto> rounds() {
        return adminService.listRounds().stream()
                .map(r -> RoundDto.from(r, scoringResultRepository.findByAssessment_Round_Id(r.getId()).orElse(null)))
                .toList();
    }

    @GetMapping("/investments")
    public List<InvestmentDto> investments() {
        return adminService.listInvestments().stream().map(InvestmentDto::from).toList();
    }

    @GetMapping("/payments")
    public List<PaymentDto> payments() {
        return adminService.listPayments().stream().map(PaymentDto::from).toList();
    }

    @GetMapping("/contracts")
    public List<ContractDto> contracts() {
        return adminService.listContracts().stream().map(ContractDto::from).toList();
    }

    @GetMapping("/users")
    public List<UserSummaryDto> users(@RequestParam(required = false) UserRole role,
                                      @RequestParam(required = false) UserStatus status) {
        return adminService.listUsers(role, status).stream().map(UserSummaryDto::from).toList();
    }

    @PatchMapping("/users/{id}/status")
    public UserSummaryDto updateUserStatus(@PathVariable Long id, @Valid @RequestBody UserStatusRequest request,
                                           @AuthenticationPrincipal SecurityUser admin) {
        return UserSummaryDto.from(adminService.updateUserStatus(admin.getId(), id, request.status(), request.notes()));
    }

    @GetMapping("/stats")
    public AdminStatsDto stats() {
        return adminService.stats();
    }
}
