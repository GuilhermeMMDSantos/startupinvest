package ao.startupinvest.scoring.dto;

import java.math.BigDecimal;

public record AssessmentRequest(
        BigDecimal marketGrowthRate,
        BigDecimal competitorsMarketShare,
        BigDecimal directCompetitorsCount,
        BigDecimal targetMarketSize,

        BigDecimal inflationRate,
        BigDecimal interestRate,
        BigDecimal unemploymentRate,

        BigDecimal customerRetentionRate,
        BigDecimal customerBaseGrowth,
        BigDecimal initialAdoptionRate,
        BigDecimal purchaseRecurrence,

        BigDecimal ltv,
        BigDecimal cac,
        BigDecimal avgTicket,
        BigDecimal revenueGrowthRate,
        BigDecimal roi,
        BigDecimal grossMargin,
        BigDecimal netMargin,
        BigDecimal receivableDays,
        BigDecimal revenueSourcesCount,
        Boolean revenueProduct,
        Boolean revenueSubscription,
        Boolean revenueAdvertising,
        Boolean revenueOther,

        BigDecimal avgExperienceYears,
        BigDecimal teamSize,
        BigDecimal managementExpCount,
        BigDecimal technicalCount,
        BigDecimal weeklyWorkHours,
        BigDecimal timeWorkingTogetherYears,

        Boolean hasIntellectualProperty,
        Boolean hasExclusiveTechnology,
        Boolean hasExclusiveDistributionChannels,
        BigDecimal automationLevel,
        Boolean participatedIncubation,
        BigDecimal previousFundingRounds,

        String businessModelType
) {
}
