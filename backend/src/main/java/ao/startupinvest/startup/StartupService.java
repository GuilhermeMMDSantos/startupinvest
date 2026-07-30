package ao.startupinvest.startup;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.startup.dto.TeamMemberRequest;
import ao.startupinvest.startup.dto.UpdateStartupRequest;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class StartupService {

    private final StartupRepository startupRepository;
    private final StartupTeamMemberRepository teamMemberRepository;

    public Startup getByOwner(Long ownerId) {
        return startupRepository.findByOwnerId(ownerId)
                .orElseThrow(() -> ApiException.notFound("Perfil de startup não encontrado"));
    }

    public Startup getPublic(Long id) {
        Startup startup = startupRepository.findById(id).orElseThrow(() -> ApiException.notFound("Startup não encontrada"));
        if (startup.getStatus() != StartupStatus.APPROVED) {
            throw ApiException.notFound("Startup não encontrada");
        }
        return startup;
    }

    @Transactional
    public Startup update(Long ownerId, UpdateStartupRequest req) {
        Startup startup = getByOwner(ownerId);
        if (req.sector() != null) startup.setSector(req.sector());
        if (req.businessModel() != null && !req.businessModel().isBlank()) {
            try {
                startup.setBusinessModel(BusinessModel.valueOf(req.businessModel().toUpperCase()));
            } catch (Exception e) {
                throw ApiException.badRequest("Modelo de negócio inválido");
            }
        }
        if (req.shortDescription() != null) startup.setShortDescription(req.shortDescription());
        if (req.website() != null) startup.setWebsite(req.website());
        if (req.paypalPayoutEmail() != null) startup.setPaypalPayoutEmail(req.paypalPayoutEmail());
        return startupRepository.save(startup);
    }

    public List<StartupTeamMember> listTeam(Long startupId) {
        return teamMemberRepository.findByStartupId(startupId);
    }

    @Transactional
    public StartupTeamMember addTeamMember(Long ownerId, TeamMemberRequest req) {
        Startup startup = getByOwner(ownerId);
        StartupTeamMember member = new StartupTeamMember();
        member.setStartup(startup);
        member.setFullName(req.fullName());
        member.setRoleTitle(req.roleTitle());
        member.setExperienceYears(req.experienceYears() != null ? req.experienceYears() : java.math.BigDecimal.ZERO);
        member.setManagement(req.management());
        member.setTechnical(req.technical());
        member.setLinkedinUrl(req.linkedinUrl());
        return teamMemberRepository.save(member);
    }

    @Transactional
    public void removeTeamMember(Long ownerId, Long memberId) {
        Startup startup = getByOwner(ownerId);
        teamMemberRepository.deleteByIdAndStartupId(memberId, startup.getId());
    }
}
