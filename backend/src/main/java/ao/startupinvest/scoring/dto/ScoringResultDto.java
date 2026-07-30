package ao.startupinvest.scoring.dto;

import ao.startupinvest.scoring.ScoringResult;

import java.math.BigDecimal;
import java.util.Map;

public record ScoringResultDto(BigDecimal growthPotentialScore, String seriesBLikelihood,
                                Map<String, Double> strengths, Map<String, Double> weaknesses) {
    public static ScoringResultDto from(ScoringResult r) {
        return new ScoringResultDto(r.getGrowthPotentialScore(), r.getSeriesBLikelihood().name(),
                r.getStrengths(), r.getWeaknesses());
    }
}
