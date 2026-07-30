package ao.startupinvest.round;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Lock;
import org.springframework.data.jpa.repository.Query;

import jakarta.persistence.LockModeType;
import java.util.List;
import java.util.Optional;

public interface FundingRoundRepository extends JpaRepository<FundingRound, Long> {
    List<FundingRound> findByStartupId(Long startupId);
    List<FundingRound> findByStatus(RoundStatus status);

    @Lock(LockModeType.PESSIMISTIC_WRITE)
    @Query("select r from FundingRound r where r.id = :id")
    Optional<FundingRound> findByIdForUpdate(Long id);
}
