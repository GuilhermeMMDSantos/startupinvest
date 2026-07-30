package ao.startupinvest.scoring;

import jakarta.persistence.*;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import org.hibernate.annotations.JdbcTypeCode;
import org.hibernate.type.SqlTypes;

import java.math.BigDecimal;
import java.time.Instant;
import java.util.Map;

@Entity
@Table(name = "scoring_results")
@Getter
@Setter
@NoArgsConstructor
public class ScoringResult {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "assessment_id", nullable = false, unique = true)
    private StartupAssessment assessment;

    @Column(name = "growth_potential_score", nullable = false, precision = 5, scale = 2)
    private BigDecimal growthPotentialScore;

    @Enumerated(EnumType.STRING)
    @Column(name = "series_b_likelihood", nullable = false, length = 20)
    private SeriesBLikelihood seriesBLikelihood;

    @JdbcTypeCode(SqlTypes.JSON)
    @Column(name = "strengths", nullable = false, columnDefinition = "jsonb")
    private Map<String, Double> strengths;

    @JdbcTypeCode(SqlTypes.JSON)
    @Column(name = "weaknesses", nullable = false, columnDefinition = "jsonb")
    private Map<String, Double> weaknesses;

    @Column(name = "computed_at", nullable = false)
    private Instant computedAt = Instant.now();
}
