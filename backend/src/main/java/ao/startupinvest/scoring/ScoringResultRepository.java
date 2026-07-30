package ao.startupinvest.scoring;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.Optional;

public interface ScoringResultRepository extends JpaRepository<ScoringResult, Long> {
    Optional<ScoringResult> findByAssessmentId(Long assessmentId);
    Optional<ScoringResult> findByAssessment_Round_Id(Long roundId);
}
