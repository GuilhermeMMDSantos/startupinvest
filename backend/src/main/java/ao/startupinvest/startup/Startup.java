package ao.startupinvest.startup;

import ao.startupinvest.user.User;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.time.Instant;
import java.time.LocalDate;

@Entity
@Table(name = "startups")
@Getter
@Setter
@NoArgsConstructor
public class Startup {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "owner_user_id", nullable = false)
    private User owner;

    @Column(nullable = false, length = 180)
    private String name;

    @Column(nullable = false, unique = true, length = 40)
    private String nif;

    @Column(length = 120)
    private String sector;

    @Enumerated(EnumType.STRING)
    @Column(name = "business_model", length = 20)
    private BusinessModel businessModel;

    @Column(name = "short_description", columnDefinition = "text")
    private String shortDescription;

    @Column(length = 255)
    private String website;

    @Column(name = "founded_at")
    private LocalDate foundedAt;

    @Column(name = "pitch_deck_path", nullable = false, length = 500)
    private String pitchDeckPath;

    @Column(name = "logo_path", length = 500)
    private String logoPath;

    @Column(name = "paypal_payout_email", length = 180)
    private String paypalPayoutEmail;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false, length = 30)
    private StartupStatus status = StartupStatus.PENDING_APPROVAL;

    @Column(name = "approved_at")
    private Instant approvedAt;

    @Column(name = "approved_by")
    private Long approvedBy;

    @Column(name = "created_at", nullable = false, updatable = false)
    private Instant createdAt = Instant.now();

    @Column(name = "updated_at", nullable = false)
    private Instant updatedAt = Instant.now();

    @PreUpdate
    public void preUpdate() {
        this.updatedAt = Instant.now();
    }
}
