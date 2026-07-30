package ao.startupinvest.auth.dto;

public record AuthResponse(String accessToken, Long userId, String email, String role, String status) {
}
