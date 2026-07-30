package ao.startupinvest.investment;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface InvestmentRepository extends JpaRepository<Investment, Long> {
    List<Investment> findByRoundId(Long roundId);
    List<Investment> findByInvestorId(Long investorId);
    List<Investment> findByRoundIdAndStatus(Long roundId, InvestmentStatus status);
    long countByRoundIdAndStatusIn(Long roundId, List<InvestmentStatus> statuses);
}
