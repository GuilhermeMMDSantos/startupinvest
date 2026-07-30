package ao.startupinvest.messaging;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.investor.InvestorProfile;
import ao.startupinvest.investor.InvestorProfileRepository;
import ao.startupinvest.notification.NotificationService;
import ao.startupinvest.round.FundingRound;
import ao.startupinvest.round.FundingRoundRepository;
import ao.startupinvest.security.SecurityUser;
import ao.startupinvest.user.UserRole;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;

@Service
@RequiredArgsConstructor
public class MessagingService {

    private final ConversationRepository conversationRepository;
    private final MessageRepository messageRepository;
    private final FundingRoundRepository fundingRoundRepository;
    private final InvestorProfileRepository investorProfileRepository;
    private final NotificationService notificationService;

    @Transactional
    public Conversation startOrGetConversation(Long roundId, SecurityUser currentUser) {
        if (currentUser.getUser().getRole() != UserRole.INVESTOR) {
            throw ApiException.forbidden("Apenas investidores podem iniciar uma conversa");
        }
        InvestorProfile investor = investorProfileRepository.findByUserId(currentUser.getId())
                .orElseThrow(() -> ApiException.badRequest("Perfil de investidor não encontrado"));
        FundingRound round = fundingRoundRepository.findById(roundId)
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));

        return conversationRepository.findByRoundIdAndInvestorId(roundId, investor.getId())
                .orElseGet(() -> {
                    Conversation c = new Conversation();
                    c.setRound(round);
                    c.setStartup(round.getStartup());
                    c.setInvestor(investor);
                    Conversation saved = conversationRepository.save(c);
                    notificationService.notify(round.getStartup().getOwner(), "NEW_CONVERSATION",
                            "Nova conversa sobre a rodada",
                            investor.getFullName() + " iniciou uma conversa sobre a rodada de " + round.getStartup().getName());
                    return saved;
                });
    }

    public List<Conversation> listForUser(SecurityUser currentUser) {
        if (currentUser.getUser().getRole() == UserRole.INVESTOR) {
            InvestorProfile investor = investorProfileRepository.findByUserId(currentUser.getId())
                    .orElseThrow(() -> ApiException.badRequest("Perfil de investidor não encontrado"));
            return conversationRepository.findByInvestorId(investor.getId());
        }
        if (currentUser.getUser().getRole() == UserRole.STARTUP_OWNER) {
            return conversationRepository.findByStartup_OwnerId(currentUser.getId());
        }
        throw ApiException.forbidden("Sem acesso a conversas");
    }

    public List<Message> listMessages(Long conversationId, SecurityUser currentUser) {
        Conversation conversation = conversationRepository.findById(conversationId)
                .orElseThrow(() -> ApiException.notFound("Conversa não encontrada"));
        assertParticipant(conversation, currentUser);
        return messageRepository.findByConversationIdOrderBySentAtAsc(conversationId);
    }

    @Transactional
    public Message sendMessage(Long conversationId, SecurityUser currentUser, String content) {
        if (content == null || content.isBlank()) {
            throw ApiException.badRequest("Mensagem vazia");
        }
        Conversation conversation = conversationRepository.findById(conversationId)
                .orElseThrow(() -> ApiException.notFound("Conversa não encontrada"));
        assertParticipant(conversation, currentUser);

        Message message = new Message();
        message.setConversation(conversation);
        message.setSender(currentUser.getUser());
        message.setContent(content);
        Message saved = messageRepository.save(message);

        var recipient = currentUser.getUser().getRole() == UserRole.INVESTOR
                ? conversation.getStartup().getOwner()
                : conversation.getInvestor().getUser();
        notificationService.notify(recipient, "NEW_MESSAGE", "Nova mensagem",
                "Tem uma nova mensagem na conversa sobre " + conversation.getStartup().getName());

        return saved;
    }

    private void assertParticipant(Conversation conversation, SecurityUser currentUser) {
        boolean isInvestor = conversation.getInvestor().getUser().getId().equals(currentUser.getId());
        boolean isStartupOwner = conversation.getStartup().getOwner().getId().equals(currentUser.getId());
        if (!isInvestor && !isStartupOwner && currentUser.getUser().getRole() != UserRole.ADMIN) {
            throw ApiException.forbidden("Sem acesso a esta conversa");
        }
    }
}
