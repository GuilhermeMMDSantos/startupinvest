package ao.startupinvest.admin;

import ao.startupinvest.admin.dto.AdminStatsDto;
import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.contract.ContractRepository;
import ao.startupinvest.contract.ContractStatus;
import ao.startupinvest.investment.InvestmentRepository;
import ao.startupinvest.investor.InvestorProfile;
import ao.startupinvest.investor.InvestorProfileRepository;
import ao.startupinvest.investor.VerificationStatus;
import ao.startupinvest.notification.NotificationService;
import ao.startupinvest.payment.PaymentRepository;
import ao.startupinvest.round.FundingRoundRepository;
import ao.startupinvest.round.RoundStatus;
import ao.startupinvest.startup.Startup;
import ao.startupinvest.startup.StartupRepository;
import ao.startupinvest.startup.StartupStatus;
import ao.startupinvest.user.User;
import ao.startupinvest.user.UserRepository;
import ao.startupinvest.user.UserRole;
import ao.startupinvest.user.UserStatus;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;
import java.time.Instant;
import java.util.List;

@Service
@RequiredArgsConstructor
public class AdminService {

    private final UserRepository userRepository;
    private final InvestorProfileRepository investorProfileRepository;
    private final StartupRepository startupRepository;
    private final FundingRoundRepository fundingRoundRepository;
    private final InvestmentRepository investmentRepository;
    private final PaymentRepository paymentRepository;
    private final ContractRepository contractRepository;
    private final NotificationService notificationService;

    public List<InvestorProfile> listInvestors(VerificationStatus status) {
        return status == null ? investorProfileRepository.findAll() : investorProfileRepository.findByVerificationStatus(status);
    }

    @Transactional
    public InvestorProfile decideInvestor(Long adminId, Long investorId, boolean approve, String notes) {
        InvestorProfile investor = investorProfileRepository.findById(investorId)
                .orElseThrow(() -> ApiException.notFound("Investidor não encontrado"));
        investor.setVerificationStatus(approve ? VerificationStatus.APPROVED : VerificationStatus.REJECTED);
        investor.setVerificationNotes(notes);
        investor.setVerifiedAt(Instant.now());
        investor.setVerifiedBy(adminId);
        investorProfileRepository.save(investor);

        var user = investor.getUser();
        user.setStatus(approve ? UserStatus.ACTIVE : UserStatus.REJECTED);
        userRepository.save(user);

        notificationService.notify(user, "VERIFICATION_DECISION", approve ? "Conta verificada" : "Verificação rejeitada",
                approve ? "A sua identidade foi verificada. Já pode investir na plataforma."
                        : "A sua verificação foi rejeitada. Motivo: " + notes);
        return investor;
    }

    public List<Startup> listStartups(StartupStatus status) {
        return status == null ? startupRepository.findAll() : startupRepository.findByStatus(status);
    }

    @Transactional
    public Startup decideStartup(Long adminId, Long startupId, boolean approve, String notes) {
        Startup startup = startupRepository.findById(startupId)
                .orElseThrow(() -> ApiException.notFound("Startup não encontrada"));
        startup.setStatus(approve ? StartupStatus.APPROVED : StartupStatus.REJECTED);
        startup.setApprovedAt(Instant.now());
        startup.setApprovedBy(adminId);
        startupRepository.save(startup);

        var owner = startup.getOwner();
        owner.setStatus(approve ? UserStatus.ACTIVE : UserStatus.REJECTED);
        userRepository.save(owner);

        notificationService.notify(owner, "STARTUP_DECISION", approve ? "Startup aprovada" : "Startup rejeitada",
                approve ? "A sua startup foi aprovada. Já pode abrir uma rodada de investimento."
                        : "O registo da sua startup foi rejeitado. Motivo: " + notes);
        return startup;
    }

    public List<ao.startupinvest.round.FundingRound> listRounds() {
        return fundingRoundRepository.findAll();
    }

    public List<ao.startupinvest.investment.Investment> listInvestments() {
        return investmentRepository.findAll();
    }

    public List<ao.startupinvest.payment.Payment> listPayments() {
        return paymentRepository.findAll();
    }

    public List<ao.startupinvest.contract.Contract> listContracts() {
        return contractRepository.findAll();
    }

    public List<User> listUsers(UserRole role, UserStatus status) {
        if (role != null && status != null) {
            return userRepository.findByRoleAndStatus(role, status);
        }
        if (role != null) {
            return userRepository.findByRole(role);
        }
        if (status != null) {
            return userRepository.findByStatus(status);
        }
        return userRepository.findAll();
    }

    @Transactional
    public User updateUserStatus(Long adminId, Long userId, UserStatus status, String notes) {
        if (status != UserStatus.ACTIVE && status != UserStatus.SUSPENDED) {
            throw ApiException.badRequest("Estado de utilizador inválido");
        }
        User user = userRepository.findById(userId)
                .orElseThrow(() -> ApiException.notFound("Utilizador não encontrado"));
        user.setStatus(status);
        userRepository.save(user);

        notificationService.notify(user, "USER_STATUS_CHANGED",
                status == UserStatus.ACTIVE ? "Conta reativada" : "Conta suspensa",
                status == UserStatus.ACTIVE
                        ? "A sua conta foi reativada pelo administrador."
                        : "A sua conta foi suspensa pelo administrador. Motivo: " + (notes == null || notes.isBlank() ? "Sem nota" : notes));
        return user;
    }

    public AdminStatsDto stats() {
        long totalUsers = userRepository.count();
        long totalInvestors = investorProfileRepository.count();
        long pendingInvestorVerifications = investorProfileRepository.findByVerificationStatus(VerificationStatus.PENDING).size();
        long totalStartups = startupRepository.count();
        long pendingStartupApprovals = startupRepository.findByStatus(StartupStatus.PENDING_APPROVAL).size();
        long openRounds = fundingRoundRepository.findByStatus(RoundStatus.OPEN).size();
        long closedSuccessRounds = fundingRoundRepository.findByStatus(RoundStatus.CLOSED_SUCCESS).size();
        BigDecimal totalRaised = fundingRoundRepository.findAll().stream()
                .map(r -> r.getAmountRaised() == null ? BigDecimal.ZERO : r.getAmountRaised())
                .reduce(BigDecimal.ZERO, BigDecimal::add);
        long totalInvestments = investmentRepository.count();
        long pendingContracts = contractRepository.findAll().stream()
                .filter(c -> c.getStatus() != ContractStatus.FULLY_SIGNED && c.getStatus() != ContractStatus.VOID)
                .count();
        return new AdminStatsDto(totalUsers, totalInvestors, pendingInvestorVerifications, totalStartups,
                pendingStartupApprovals, openRounds, closedSuccessRounds, totalRaised, totalInvestments, pendingContracts);
    }
}
