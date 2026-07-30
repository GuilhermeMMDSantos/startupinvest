package ao.startupinvest.startup;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.math.BigDecimal;
import java.time.Instant;

@Entity
@Table(name = "startup_team_members")
@Getter
@Setter
@NoArgsConstructor
public class StartupTeamMember {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "startup_id", nullable = false)
    private Startup startup;

    @Column(name = "full_name", nullable = false, length = 180)
    private String fullName;

    @Column(name = "role_title", nullable = false, length = 120)
    private String roleTitle;

    @Column(name = "experience_years", nullable = false, precision = 5, scale = 2)
    private BigDecimal experienceYears = BigDecimal.ZERO;

    @Column(name = "is_management", nullable = false)
    private boolean management;

    @Column(name = "is_technical", nullable = false)
    private boolean technical;

    @Column(name = "linkedin_url", length = 255)
    private String linkedinUrl;

    @Column(name = "created_at", nullable = false, updatable = false)
    private Instant createdAt = Instant.now();
}
