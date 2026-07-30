package ao.startupinvest.round;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.investment.InvestmentRepository;
import ao.startupinvest.investment.InvestmentStatus;
import ao.startupinvest.round.dto.CreateRoundRequest;
import ao.startupinvest.scoring.ScoringResultRepository;
import ao.startupinvest.startup.Startup;
import ao.startupinvest.startup.StartupRepository;
import ao.startupinvest.startup.StartupStatus;
import ao.startupinvest.storage.FileStorageService;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.multipart.MultipartFile;

import java.time.Instant;
import java.util.List;

@Service
@RequiredArgsConstructor
public class RoundService {

    private final FundingRoundRepository fundingRoundRepository;
    private final StartupRepository startupRepository;
    private final InvestmentRepository investmentRepository;
    private final ScoringResultRepository scoringResultRepository;
    private final RoundMathService roundMathService;
    private final FileStorageService fileStorageService;

    @Transactional
    public FundingRound create(Long ownerId, CreateRoundRequest req, MultipartFile pitchVideo) {
        Startup startup = startupRepository.findByOwnerId(ownerId)
                .orElseThrow(() -> ApiException.notFound("Perfil de startup não encontrado"));
        if (startup.getStatus() != StartupStatus.APPROVED) {
            throw ApiException.badRequest("A startup precisa de ser aprovada pelo admin antes de abrir uma rodada");
        }
        boolean hasOngoing = fundingRoundRepository.findByStartupId(startup.getId()).stream()
                .anyMatch(r -> r.getStatus() == RoundStatus.OPEN || r.getStatus() == RoundStatus.DRAFT
                        || r.getStatus() == RoundStatus.CONTRACTS_PENDING);
        if (hasOngoing) {
            throw ApiException.conflict("Já existe uma rodada em curso para esta startup");
        }

        roundMathService.validateRoundCreation(req.targetAmount(), req.equityOfferedPct(), req.maxInvestors());

        FundingRound round = new FundingRound();
        round.setStartup(startup);
        round.setTargetAmount(req.targetAmount());
        round.setEquityOfferedPct(req.equityOfferedPct());
        round.setMaxInvestors(req.maxInvestors());
        round.setMinTicket(roundMathService.computeMinTicket(req.targetAmount(), req.maxInvestors()));
        if (req.contractType() != null && !req.contractType().isBlank()) {
            try {
                round.setContractType(ao.startupinvest.contract.ContractType.valueOf(req.contractType().toUpperCase()));
            } catch (Exception ignored) {
            }
        }
        round.setPitchVideoPath(fileStorageService.store(pitchVideo, "rounds/videos"));
        round.setStatus(RoundStatus.DRAFT);
        return fundingRoundRepository.save(round);
    }

    @Transactional
    public FundingRound open(Long ownerId, Long roundId) {
        FundingRound round = getOwnedRound(ownerId, roundId);
        if (round.getStatus() != RoundStatus.DRAFT) {
            throw ApiException.badRequest("Só é possível abrir uma rodada em rascunho");
        }
        if (round.getStartup().getPaypalPayoutEmail() == null || round.getStartup().getPaypalPayoutEmail().isBlank()) {
            throw ApiException.badRequest("Configure o email PayPal de recebimento da startup antes de abrir a rodada");
        }
        if (scoringResultRepository.findByAssessment_Round_Id(roundId).isEmpty()) {
            throw ApiException.badRequest("Submeta o questionário de avaliação da startup antes de abrir a rodada");
        }
        round.setStatus(RoundStatus.OPEN);
        round.setOpenedAt(Instant.now());
        return fundingRoundRepository.save(round);
    }

    @Transactional
    public FundingRound cancel(Long ownerId, Long roundId) {
        FundingRound round = getOwnedRound(ownerId, roundId);
        if (round.getStatus() != RoundStatus.DRAFT && round.getStatus() != RoundStatus.OPEN) {
            throw ApiException.badRequest("Esta rodada já não pode ser cancelada");
        }
        boolean hasPaidInvestments = !investmentRepository.findByRoundIdAndStatus(roundId, InvestmentStatus.PAID).isEmpty()
                || !investmentRepository.findByRoundIdAndStatus(roundId, InvestmentStatus.CONFIRMED).isEmpty();
        if (hasPaidInvestments) {
            throw ApiException.conflict("Não é possível cancelar uma rodada com investimentos já pagos");
        }
        round.setStatus(RoundStatus.CLOSED_CANCELLED);
        round.setClosedAt(Instant.now());
        return fundingRoundRepository.save(round);
    }

    public FundingRound getOwnedRound(Long ownerId, Long roundId) {
        FundingRound round = fundingRoundRepository.findById(roundId)
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));
        if (!round.getStartup().getOwner().getId().equals(ownerId)) {
            throw ApiException.forbidden("Esta rodada não pertence à sua startup");
        }
        return round;
    }

    public List<FundingRound> listOpen() {
        return fundingRoundRepository.findByStatus(RoundStatus.OPEN);
    }

    public List<FundingRound> listMine(Long ownerId) {
        Startup startup = startupRepository.findByOwnerId(ownerId)
                .orElseThrow(() -> ApiException.notFound("Perfil de startup não encontrado"));
        return fundingRoundRepository.findByStartupId(startup.getId());
    }

    public FundingRound getVisible(Long roundId) {
        FundingRound round = fundingRoundRepository.findById(roundId)
                .orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));
        if (round.getStatus() == RoundStatus.DRAFT) {
            throw ApiException.notFound("Rodada não encontrada");
        }
        return round;
    }

    public FundingRound getById(Long roundId) {
        return fundingRoundRepository.findById(roundId).orElseThrow(() -> ApiException.notFound("Rodada não encontrada"));
    }
}
