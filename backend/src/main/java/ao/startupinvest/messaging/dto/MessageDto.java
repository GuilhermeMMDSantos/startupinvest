package ao.startupinvest.messaging.dto;

import ao.startupinvest.messaging.Message;

import java.time.Instant;

public record MessageDto(Long id, Long senderId, String senderName, String content, Instant sentAt) {
    public static MessageDto from(Message m) {
        return new MessageDto(m.getId(), m.getSender().getId(), m.getSender().getEmail(), m.getContent(), m.getSentAt());
    }
}
