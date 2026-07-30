package ao.startupinvest.user.dto;

import ao.startupinvest.user.User;

import java.time.Instant;

public record UserSummaryDto(Long id, String email, String role, String status, Instant createdAt, Instant updatedAt) {
    public static UserSummaryDto from(User user) {
        return new UserSummaryDto(user.getId(), user.getEmail(), user.getRole().name(), user.getStatus().name(),
                user.getCreatedAt(), user.getUpdatedAt());
    }
}