package ao.startupinvest.scoring;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.round.FundingRound;
import ao.startupinvest.round.FundingRoundRepository;
import ao.startupinvest.round.RoundStatus;
import ao.startupinvest.scoring.dto.AssessmentRequest;
import ao.startupinvest.startup.BusinessModel;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.math.BigDecimal;

@Service
@RequiredArgsConstructor
public class ScoringService {

    private final FundingRoundRepository fundingRoundRepository;
    private final StartupAssessmentRepository assessmentRepository;
    private final ScoringResultRepository scoringResultRepository;
    private final ScoringEngine scoringEngine;

    @Transactional
    public ScoringResult submitAssessment(Long ownerId, Long roundId, AssessmentRequest req) {
        FundingRound round = fundingRoundRepository.findById(roundId)
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));
        if (!round.getStartup().getOwner().getId().equals(ownerId)) {
            throw ApiException.forbidden("Esta rodada não pertence à sua startup");
        }
        if (round.getStatus() != RoundStatus.DRAFT) {
            throw ApiException.badRequest("A avaliação só pode ser submetida enquanto a rodada está em rascunho");
        }

        StartupAssessment assessment = assessmentRepository.findByRoundId(roundId).orElseGet(StartupAssessment::new);
        assessment.setRound(round);
        applyRequest(assessment, req);
        assessment = assessmentRepository.save(assessment);

        ScoringEngine.Evaluation evaluation = scoringEngine.evaluate(assessment);

        ScoringResult result = scoringResultRepository.findByAssessmentId(assessment.getId()).orElseGet(ScoringResult::new);
        result.setAssessment(assessment);
        result.setGrowthPotentialScore(evaluation.growthPotentialScore());
        result.setSeriesBLikelihood(evaluation.seriesBLikelihood());
        result.setStrengths(evaluation.strengths());
        result.setWeaknesses(evaluation.weaknesses());
        result.setComputedAt(java.time.Instant.now());
        return scoringResultRepository.save(result);
    }

    public ScoringResult getForRound(Long roundId) {
        return scoringResultRepository.findByAssessment_Round_Id(roundId)
                .orElseThrow(() -> ApiException.notFound("Avaliação ainda não submetida para esta rodada"));
    }

    private void applyRequest(StartupAssessment a, AssessmentRequest r) {
        a.setMarketGrowthRate(nz(r.marketGrowthRate()));
        a.setCompetitorsMarketShare(nz(r.competitorsMarketShare()));
        a.setDirectCompetitorsCount(nz(r.directCompetitorsCount()));
        a.setTargetMarketSize(nz(r.targetMarketSize()));

        a.setInflationRate(nz(r.inflationRate()));
        a.setInterestRate(nz(r.interestRate()));
        a.setUnemploymentRate(nz(r.unemploymentRate()));

        a.setCustomerRetentionRate(nz(r.customerRetentionRate()));
        a.setCustomerBaseGrowth(nz(r.customerBaseGrowth()));
        a.setInitialAdoptionRate(nz(r.initialAdoptionRate()));
        a.setPurchaseRecurrence(nz(r.purchaseRecurrence()));

        a.setLtv(nz(r.ltv()));
        a.setCac(nz(r.cac()));
        a.setAvgTicket(nz(r.avgTicket()));
        a.setRevenueGrowthRate(nz(r.revenueGrowthRate()));
        a.setRoi(nz(r.roi()));
        a.setGrossMargin(nz(r.grossMargin()));
        a.setNetMargin(nz(r.netMargin()));
        a.setReceivableDays(nz(r.receivableDays()));
        a.setRevenueSourcesCount(nz(r.revenueSourcesCount()));
        a.setRevenueProduct(Boolean.TRUE.equals(r.revenueProduct()));
        a.setRevenueSubscription(Boolean.TRUE.equals(r.revenueSubscription()));
        a.setRevenueAdvertising(Boolean.TRUE.equals(r.revenueAdvertising()));
        a.setRevenueOther(Boolean.TRUE.equals(r.revenueOther()));

        a.setAvgExperienceYears(nz(r.avgExperienceYears()));
        a.setTeamSize(nz(r.teamSize()));
        a.setManagementExpCount(nz(r.managementExpCount()));
        a.setTechnicalCount(nz(r.technicalCount()));
        a.setWeeklyWorkHours(nz(r.weeklyWorkHours()));
        a.setTimeWorkingTogetherYears(nz(r.timeWorkingTogetherYears()));

        a.setHasIntellectualProperty(Boolean.TRUE.equals(r.hasIntellectualProperty()));
        a.setHasExclusiveTechnology(Boolean.TRUE.equals(r.hasExclusiveTechnology()));
        a.setHasExclusiveDistributionChannels(Boolean.TRUE.equals(r.hasExclusiveDistributionChannels()));
        a.setAutomationLevel(nz(r.automationLevel()));
        a.setParticipatedIncubation(Boolean.TRUE.equals(r.participatedIncubation()));
        a.setPreviousFundingRounds(nz(r.previousFundingRounds()));

        if (r.businessModelType() != null && !r.businessModelType().isBlank()) {
            try {
                a.setBusinessModelType(BusinessModel.valueOf(r.businessModelType().toUpperCase()));
            } catch (Exception ignored) {
            }
        }
    }

    private BigDecimal nz(BigDecimal v) {
        return v == null ? BigDecimal.ZERO : v;
    }
}
