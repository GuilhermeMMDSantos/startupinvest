package ao.startupinvest.startup.dto;

import jakarta.validation.constraints.NotBlank;

import java.math.BigDecimal;

public record TeamMemberRequest(@NotBlank String fullName, @NotBlank String roleTitle, BigDecimal experienceYears,
                                 boolean management, boolean technical, String linkedinUrl) {
}
