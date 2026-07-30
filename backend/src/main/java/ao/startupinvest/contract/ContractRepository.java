package ao.startupinvest.contract;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

public interface ContractRepository extends JpaRepository<Contract, Long> {
    Optional<Contract> findByInvestmentId(Long investmentId);
    List<Contract> findByInvestment_Round_Id(Long roundId);
}
