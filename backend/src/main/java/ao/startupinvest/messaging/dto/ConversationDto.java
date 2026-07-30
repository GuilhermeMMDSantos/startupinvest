package ao.startupinvest.messaging.dto;

import ao.startupinvest.messaging.Conversation;

import java.time.Instant;

public record ConversationDto(Long id, Long roundId, String startupName, String investorName, Instant createdAt) {
    public static ConversationDto from(Conversation c) {
        return new ConversationDto(c.getId(), c.getRound().getId(), c.getStartup().getName(),
                c.getInvestor().getFullName(), c.getCreatedAt());
    }
}
