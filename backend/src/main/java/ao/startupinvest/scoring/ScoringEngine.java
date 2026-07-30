package ao.startupinvest.scoring;

import org.springframework.stereotype.Component;

import java.math.BigDecimal;
import java.math.RoundingMode;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;


@Component
public class ScoringEngine {

    private static final double WEAKNESS_THRESHOLD = 40.0;
    private static final double STRENGTH_THRESHOLD = 75.0;
    private static final double LTV_CAC_MAX = 5.0;
    private static final double LTV_CAC_WEIGHT = 5.0;

    private static final List<MetricDefinition> METRICS = List.of(
            new MetricDefinition("taxa_crescimento_mercado", "Taxa de crescimento do mercado", 6, 0, 50, true, StartupAssessment::getMarketGrowthRate),
            new MetricDefinition("participacao_mercado_concorrentes", "Participação de mercado dos concorrentes", 5, 0, 100, false, StartupAssessment::getCompetitorsMarketShare),
            new MetricDefinition("numero_concorrentes_diretos", "Número de concorrentes diretos", 4, 0, 20, false, StartupAssessment::getDirectCompetitorsCount),
            new MetricDefinition("tamanho_mercado_alvo", "Tamanho do mercado alvo", 5, 0, 5_000_000_000.0, true, StartupAssessment::getTargetMarketSize),

            new MetricDefinition("taxa_retencao_clientes", "Taxa de retenção de clientes", 5, 0, 100, true, StartupAssessment::getCustomerRetentionRate),
            new MetricDefinition("crescimento_base_clientes", "Crescimento da base de clientes", 4, 0, 100, true, StartupAssessment::getCustomerBaseGrowth),
            new MetricDefinition("taxa_adocao_inicial", "Taxa de adoção inicial", 3, 0, 100, true, StartupAssessment::getInitialAdoptionRate),
            new MetricDefinition("recorrencia_compra", "Recorrência de compra", 3, 0, 100, true, StartupAssessment::getPurchaseRecurrence),

            new MetricDefinition("taxa_crescimento_receita", "Taxa de crescimento da receita", 6, 0, 100, true, StartupAssessment::getRevenueGrowthRate),
            new MetricDefinition("roi", "ROI", 6, -50, 100, true, StartupAssessment::getRoi),
            new MetricDefinition("margem_bruta", "Margem bruta", 5, 0, 100, true, StartupAssessment::getGrossMargin),
            new MetricDefinition("margem_liquida", "Margem líquida", 4, -20, 50, true, StartupAssessment::getNetMargin),
            new MetricDefinition("tempo_recebimento", "Tempo de recebimento", 2, 0, 90, false, StartupAssessment::getReceivableDays),
            new MetricDefinition("qtd_fontes_receita", "Quantidade de fontes de receita", 2, 0, 4, true, StartupAssessment::getRevenueSourcesCount),

            new MetricDefinition("media_experiencia", "Média de experiência da equipa", 5, 0, 15, true, StartupAssessment::getAvgExperienceYears),
            new MetricDefinition("tamanho_equipe", "Tamanho da equipa", 3, 1, 15, true, StartupAssessment::getTeamSize),
            new MetricDefinition("qtd_exp_gestao", "Experiência em gestão", 3, 0, 5, true, StartupAssessment::getManagementExpCount),
            new MetricDefinition("qtd_tecnico", "Perfil técnico", 3, 0, 5, true, StartupAssessment::getTechnicalCount),
            new MetricDefinition("horas_trabalho_semana", "Horas de trabalho por semana", 3, 0, 60, true, StartupAssessment::getWeeklyWorkHours),
            new MetricDefinition("tempo_trabalho_juntos", "Tempo de equipa junta", 3, 0, 5, true, StartupAssessment::getTimeWorkingTogetherYears),

            new MetricDefinition("propriedade_intelectual", "Propriedade intelectual", 2, 0, 1, true, a -> bool(a.isHasIntellectualProperty())),
            new MetricDefinition("tecnologia_exclusiva", "Tecnologia exclusiva", 2, 0, 1, true, a -> bool(a.isHasExclusiveTechnology())),
            new MetricDefinition("acesso_canais_distribuicao", "Acesso a canais de distribuição exclusivos", 2, 0, 1, true, a -> bool(a.isHasExclusiveDistributionChannels())),
            new MetricDefinition("grau_automacao", "Grau de automação", 3, 0, 100, true, StartupAssessment::getAutomationLevel),
            new MetricDefinition("participou_incubacao", "Participação em incubadora/aceleradora", 2, 0, 1, true, a -> bool(a.isParticipatedIncubation())),
            new MetricDefinition("rodadas_investimento", "Rodadas de investimento anteriores", 2, 0, 3, true, StartupAssessment::getPreviousFundingRounds),
            new MetricDefinition("taxa_inflacao", "Taxa de inflação", 1, 0, 50, false, StartupAssessment::getInflationRate),
            new MetricDefinition("taxas_juros", "Taxas de juro", 0.5, 0, 50, false, StartupAssessment::getInterestRate),
            new MetricDefinition("taxa_desemprego", "Taxa de desemprego", 0.5, 0, 50, false, StartupAssessment::getUnemploymentRate)
    );

    private static BigDecimal bool(boolean b) {
        return b ? BigDecimal.ONE : BigDecimal.ZERO;
    }

    public Evaluation evaluate(StartupAssessment assessment) {
        double totalWeight = 0.0;
        double weightedScore = 0.0;
        Map<String, Double> weaknesses = new LinkedHashMap<>();
        Map<String, Double> strengths = new LinkedHashMap<>();

        for (MetricDefinition metric : METRICS) {
            double raw = metric.rawValue(assessment);
            double score = normalize(raw, metric.min(), metric.max(), metric.higherIsBetter());
            weightedScore += score * metric.weight();
            totalWeight += metric.weight();
            classify(weaknesses, strengths, metric.displayName(), raw, score);
        }

        double ltv = assessment.getLtv() == null ? 0.0 : assessment.getLtv().doubleValue();
        double cac = assessment.getCac() == null ? 0.0 : assessment.getCac().doubleValue();
        double ltvCacRatio = cac > 0 ? ltv / cac : (ltv > 0 ? LTV_CAC_MAX : 0);
        double ltvCacScore = normalize(ltvCacRatio, 0, LTV_CAC_MAX, true);

        weightedScore += ltvCacScore * LTV_CAC_WEIGHT;
        totalWeight += LTV_CAC_WEIGHT;
        classify(weaknesses, strengths, "LTV", ltv, ltvCacScore);
        classify(weaknesses, strengths, "CAC", cac, ltvCacScore);

        double growthPotential = totalWeight > 0 ? Math.round(weightedScore / totalWeight * 100.0) / 100.0 : 0;
        SeriesBLikelihood likelihood = classifyLikelihood(growthPotential);

        return new Evaluation(BigDecimal.valueOf(growthPotential).setScale(2, RoundingMode.HALF_UP),
                likelihood, strengths, weaknesses);
    }

    private SeriesBLikelihood classifyLikelihood(double score) {
        if (score < WEAKNESS_THRESHOLD) return SeriesBLikelihood.BAIXO;
        if (score >= STRENGTH_THRESHOLD) return SeriesBLikelihood.ALTO;
        return SeriesBLikelihood.MEDIO;
    }

    private double normalize(double value, double min, double max, boolean higherIsBetter) {
        double clamped = Math.max(min, Math.min(max, value));
        double ratio = max == min ? 1.0 : (clamped - min) / (max - min);
        double score = ratio * 100;
        return higherIsBetter ? score : 100 - score;
    }

    private void classify(Map<String, Double> weaknesses, Map<String, Double> strengths, String display,
                           double rawValue, double score) {
        if (score < WEAKNESS_THRESHOLD) {
            weaknesses.put(display, rawValue);
        } else if (score >= STRENGTH_THRESHOLD) {
            strengths.put(display, rawValue);
        }
    }

    public record Evaluation(BigDecimal growthPotentialScore, SeriesBLikelihood seriesBLikelihood,
                              Map<String, Double> strengths, Map<String, Double> weaknesses) {
    }
}
