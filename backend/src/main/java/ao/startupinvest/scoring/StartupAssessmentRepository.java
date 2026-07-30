package ao.startupinvest.scoring;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface StartupAssessmentRepository extends JpaRepository<StartupAssessment, Long> {
    Optional<StartupAssessment> findByRoundId(Long roundId);
}
