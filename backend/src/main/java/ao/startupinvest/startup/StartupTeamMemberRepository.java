package ao.startupinvest.startup;

import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface StartupTeamMemberRepository extends JpaRepository<StartupTeamMember, Long> {
    List<StartupTeamMember> findByStartupId(Long startupId);
    void deleteByIdAndStartupId(Long id, Long startupId);
}
