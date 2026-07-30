package ao.startupinvest.round;

import ao.startupinvest.startup.Startup;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.math.BigDecimal;
import java.time.Instant;

@Entity
@Table(name = "funding_rounds")
@Getter
@Setter
@NoArgsConstructor
public class FundingRound {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "startup_id", nullable = false)
    private Startup startup;

    @Column(name = "target_amount", nullable = false, precision = 18, scale = 2)
    private BigDecimal targetAmount;

    @Column(name = "equity_offered_pct", nullable = false, precision = 5, scale = 2)
    private BigDecimal equityOfferedPct;

    @Column(name = "max_investors", nullable = false)
    private Integer maxInvestors;

    @Column(name = "min_ticket", nullable = false, precision = 18, scale = 2)
    private BigDecimal minTicket;

    @Column(name = "amount_raised", nullable = false, precision = 18, scale = 2)
    private BigDecimal amountRaised = BigDecimal.ZERO;

    @Enumerated(EnumType.STRING)
    @Column(name = "contract_type", nullable = false, length = 30)
    private ao.startupinvest.contract.ContractType contractType = ao.startupinvest.contract.ContractType.EQUITY_INVESTMENT;

    @Column(name = "pitch_video_path", nullable = false, length = 500)
    private String pitchVideoPath;

    @Enumerated(EnumType.STRING)
    @Column(nullable = false, length = 30)
    private RoundStatus status = RoundStatus.DRAFT;

    @Column(name = "opened_at")
    private Instant openedAt;

    @Column(name = "closed_at")
    private Instant closedAt;

    @Column(name = "created_at", nullable = false, updatable = false)
    private Instant createdAt = Instant.now();

    @Column(name = "updated_at", nullable = false)
    private Instant updatedAt = Instant.now();

    @PreUpdate
    public void preUpdate() {
        this.updatedAt = Instant.now();
    }

    public BigDecimal remaining() {
        return targetAmount.subtract(amountRaised);
    }
}
