package ao.startupinvest.startup;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;
import java.util.Optional;

public interface StartupRepository extends JpaRepository<Startup, Long> {
    Optional<Startup> findByOwnerId(Long ownerId);
    boolean existsByNifIgnoreCase(String nif);
    List<Startup> findByStatus(StartupStatus status);
}
