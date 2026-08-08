package ao.startupinvest.messaging;

import ao.startupinvest.messaging.dto.ConversationDto;
import ao.startupinvest.messaging.dto.MessageDto;
import ao.startupinvest.messaging.dto.SendMessageRequest;
import ao.startupinvest.security.SecurityUser;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/conversations")
@RequiredArgsConstructor
@Transactional
public class MessagingController {

    private final MessagingService messagingService;

    @PostMapping("/start")
    public ConversationDto start(@RequestParam Long roundId, @AuthenticationPrincipal SecurityUser user) {
        return ConversationDto.from(messagingService.startOrGetConversation(roundId, user));
    }

    @GetMapping
    public List<ConversationDto> list(@AuthenticationPrincipal SecurityUser user) {
        return messagingService.listForUser(user).stream().map(ConversationDto::from).toList();
    }

    @GetMapping("/{id}/messages")
    public List<MessageDto> messages(@PathVariable Long id, @AuthenticationPrincipal SecurityUser user) {
        return messagingService.listMessages(id, user).stream().map(MessageDto::from).toList();
    }

    @PostMapping("/{id}/messages")
    public MessageDto send(@PathVariable Long id, @Valid @RequestBody SendMessageRequest request,
                            @AuthenticationPrincipal SecurityUser user) {
        return MessageDto.from(messagingService.sendMessage(id, user, request.content()));
    }
}
