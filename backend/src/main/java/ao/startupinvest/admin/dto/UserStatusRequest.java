package ao.startupinvest.admin.dto;

import ao.startupinvest.user.UserStatus;

public record UserStatusRequest(UserStatus status, String notes) {
}