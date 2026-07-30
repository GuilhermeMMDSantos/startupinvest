package ao.startupinvest.round.dto;

import ao.startupinvest.round.FundingRound;
import ao.startupinvest.scoring.ScoringResult;

import java.math.BigDecimal;
import java.time.Instant;
import java.util.Map;

public record RoundDto(
        Long id,
        Long startupId,
        String startupName,
        String startupSector,
        BigDecimal targetAmount,
        BigDecimal equityOfferedPct,
        Integer maxInvestors,
        BigDecimal minTicket,
        BigDecimal amountRaised,
        String contractType,
        String pitchVideoPath,
        String status,
        Instant openedAt,
        ScoringSummary scoring
) {
    public record ScoringSummary(BigDecimal growthPotentialScore, String seriesBLikelihood,
                                  Map<String, Double> strengths, Map<String, Double> weaknesses) {
        public static ScoringSummary from(ScoringResult r) {
            if (r == null) return null;
            return new ScoringSummary(r.getGrowthPotentialScore(), r.getSeriesBLikelihood().name(),
                    r.getStrengths(), r.getWeaknesses());
        }
    }

    public static RoundDto from(FundingRound r, ScoringResult scoringResult) {
        return new RoundDto(r.getId(), r.getStartup().getId(), r.getStartup().getName(), r.getStartup().getSector(),
                r.getTargetAmount(), r.getEquityOfferedPct(), r.getMaxInvestors(), r.getMinTicket(),
                r.getAmountRaised(), r.getContractType().name(), r.getPitchVideoPath(), r.getStatus().name(), r.getOpenedAt(),
                ScoringSummary.from(scoringResult));
    }
}
