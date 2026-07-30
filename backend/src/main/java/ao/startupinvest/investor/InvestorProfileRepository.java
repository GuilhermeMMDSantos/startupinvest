package ao.startupinvest.investor;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

public interface InvestorProfileRepository extends JpaRepository<InvestorProfile, Long> {
    Optional<InvestorProfile> findByUserId(Long userId);
    boolean existsByDocumentTypeAndDocumentNumber(DocumentType documentType, String documentNumber);
    List<InvestorProfile> findByVerificationStatus(VerificationStatus status);
}
