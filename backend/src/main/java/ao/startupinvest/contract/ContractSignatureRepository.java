package ao.startupinvest.contract;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

public interface ContractSignatureRepository extends JpaRepository<ContractSignature, Long> {
    List<ContractSignature> findByContractId(Long contractId);
    Optional<ContractSignature> findByContractIdAndSignerRole(Long contractId, SignerRole role);
}
