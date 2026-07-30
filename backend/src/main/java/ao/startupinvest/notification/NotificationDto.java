package ao.startupinvest.notification;

import java.time.Instant;

public record NotificationDto(Long id, String type, String title, String body, Instant readAt, Instant createdAt) {
    public static NotificationDto from(Notification n) {
        return new NotificationDto(n.getId(), n.getType(), n.getTitle(), n.getBody(), n.getReadAt(), n.getCreatedAt());
    }
}
