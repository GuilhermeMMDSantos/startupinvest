package ao.startupinvest.messaging;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

public interface ConversationRepository extends JpaRepository<Conversation, Long> {
    Optional<Conversation> findByRoundIdAndInvestorId(Long roundId, Long investorId);
    List<Conversation> findByInvestorId(Long investorId);
    List<Conversation> findByStartupId(Long startupId);
    List<Conversation> findByStartup_OwnerId(Long ownerId);
}
