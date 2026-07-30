package ao.startupinvest.scoring;

import ao.startupinvest.round.FundingRound;
import ao.startupinvest.startup.BusinessModel;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.math.BigDecimal;
import java.time.Instant;

/**
 * Structured questionnaire ("entrada do modelo") a startup submits when opening a round,
 * covering market, traction, financials, team and moat/replication-difficulty factors.
 * Feeds the statistical scoring engine that estimates likelihood of reaching Series B.
 */
@Entity
@Table(name = "startup_assessments")
@Getter
@Setter
@NoArgsConstructor
public class StartupAssessment {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @OneToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "round_id", nullable = false, unique = true)
    private FundingRound round;

    // Mercado
    @Column(name = "market_growth_rate") private BigDecimal marketGrowthRate = BigDecimal.ZERO;
    @Column(name = "competitors_market_share") private BigDecimal competitorsMarketShare = BigDecimal.ZERO;
    @Column(name = "direct_competitors_count") private BigDecimal directCompetitorsCount = BigDecimal.ZERO;
    @Column(name = "target_market_size") private BigDecimal targetMarketSize = BigDecimal.ZERO;

    // Macro
    @Column(name = "inflation_rate") private BigDecimal inflationRate = BigDecimal.ZERO;
    @Column(name = "interest_rate") private BigDecimal interestRate = BigDecimal.ZERO;
    @Column(name = "unemployment_rate") private BigDecimal unemploymentRate = BigDecimal.ZERO;

    // Tração
    @Column(name = "customer_retention_rate") private BigDecimal customerRetentionRate = BigDecimal.ZERO;
    @Column(name = "customer_base_growth") private BigDecimal customerBaseGrowth = BigDecimal.ZERO;
    @Column(name = "initial_adoption_rate") private BigDecimal initialAdoptionRate = BigDecimal.ZERO;
    @Column(name = "purchase_recurrence") private BigDecimal purchaseRecurrence = BigDecimal.ZERO;

    // Financeiro
    @Column(name = "ltv") private BigDecimal ltv = BigDecimal.ZERO;
    @Column(name = "cac") private BigDecimal cac = BigDecimal.ZERO;
    @Column(name = "avg_ticket") private BigDecimal avgTicket = BigDecimal.ZERO;
    @Column(name = "revenue_growth_rate") private BigDecimal revenueGrowthRate = BigDecimal.ZERO;
    @Column(name = "roi") private BigDecimal roi = BigDecimal.ZERO;
    @Column(name = "gross_margin") private BigDecimal grossMargin = BigDecimal.ZERO;
    @Column(name = "net_margin") private BigDecimal netMargin = BigDecimal.ZERO;
    @Column(name = "receivable_days") private BigDecimal receivableDays = BigDecimal.ZERO;
    @Column(name = "revenue_sources_count") private BigDecimal revenueSourcesCount = BigDecimal.ZERO;
    @Column(name = "revenue_product") private boolean revenueProduct;
    @Column(name = "revenue_subscription") private boolean revenueSubscription;
    @Column(name = "revenue_advertising") private boolean revenueAdvertising;
    @Column(name = "revenue_other") private boolean revenueOther;

    // Equipa
    @Column(name = "avg_experience_years") private BigDecimal avgExperienceYears = BigDecimal.ZERO;
    @Column(name = "team_size") private BigDecimal teamSize = BigDecimal.ZERO;
    @Column(name = "management_exp_count") private BigDecimal managementExpCount = BigDecimal.ZERO;
    @Column(name = "technical_count") private BigDecimal technicalCount = BigDecimal.ZERO;
    @Column(name = "weekly_work_hours") private BigDecimal weeklyWorkHours = BigDecimal.ZERO;
    @Column(name = "time_working_together_years") private BigDecimal timeWorkingTogetherYears = BigDecimal.ZERO;

    // Dificuldade de réplica / moat
    @Column(name = "has_intellectual_property") private boolean hasIntellectualProperty;
    @Column(name = "has_exclusive_technology") private boolean hasExclusiveTechnology;
    @Column(name = "has_exclusive_distribution_channels") private boolean hasExclusiveDistributionChannels;
    @Column(name = "automation_level") private BigDecimal automationLevel = BigDecimal.ZERO;
    @Column(name = "participated_incubation") private boolean participatedIncubation;
    @Column(name = "previous_funding_rounds") private BigDecimal previousFundingRounds = BigDecimal.ZERO;

    @Enumerated(EnumType.STRING)
    @Column(name = "business_model_type", length = 20)
    private BusinessModel businessModelType;

    @Column(name = "created_at", nullable = false, updatable = false)
    private Instant createdAt = Instant.now();
}
