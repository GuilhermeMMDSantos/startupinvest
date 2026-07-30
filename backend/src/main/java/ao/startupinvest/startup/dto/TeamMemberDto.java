package ao.startupinvest.startup.dto;

import ao.startupinvest.startup.StartupTeamMember;

import java.math.BigDecimal;

public record TeamMemberDto(Long id, String fullName, String roleTitle, BigDecimal experienceYears,
                             boolean management, boolean technical, String linkedinUrl) {
    public static TeamMemberDto from(StartupTeamMember m) {
        return new TeamMemberDto(m.getId(), m.getFullName(), m.getRoleTitle(), m.getExperienceYears(),
                m.isManagement(), m.isTechnical(), m.getLinkedinUrl());
    }
}
