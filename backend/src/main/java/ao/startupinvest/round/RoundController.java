package ao.startupinvest.round;

import ao.startupinvest.round.dto.CreateRoundRequest;
import ao.startupinvest.round.dto.RoundDto;
import ao.startupinvest.scoring.ScoringResultRepository;
import ao.startupinvest.security.SecurityUser;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.math.BigDecimal;
import java.util.List;

@RestController
@RequestMapping("/api/rounds")
@RequiredArgsConstructor
@Transactional
public class RoundController {

    private final RoundService roundService;
    private final ScoringResultRepository scoringResultRepository;

    @GetMapping
    public List<RoundDto> listOpen() {
        return roundService.listOpen().stream().map(this::toDto).toList();
    }

    @GetMapping("/mine")
    public List<RoundDto> mine(@AuthenticationPrincipal SecurityUser user) {
        return roundService.listMine(user.getId()).stream().map(this::toDto).toList();
    }

    @GetMapping("/{id}")
    public RoundDto get(@PathVariable Long id) {
        return toDto(roundService.getVisible(id));
    }

    @GetMapping("/{id}/owner")
    public RoundDto getOwned(@PathVariable Long id, @AuthenticationPrincipal SecurityUser user) {
        return toDto(roundService.getOwnedRound(user.getId(), id));
    }

    @PostMapping(consumes = "multipart/form-data")
    public RoundDto create(@RequestParam BigDecimal targetAmount,
                            @RequestParam BigDecimal equityOfferedPct,
                            @RequestParam Integer maxInvestors,
                            @RequestParam(required = false, defaultValue = "EQUITY_INVESTMENT") String contractType,
                            @RequestParam MultipartFile pitchVideo,
                            @AuthenticationPrincipal SecurityUser user) {
        FundingRound round = roundService.create(user.getId(),
                new CreateRoundRequest(targetAmount, equityOfferedPct, maxInvestors, contractType), pitchVideo);
        return toDto(round);
    }

    @PostMapping("/{id}/open")
    public RoundDto open(@PathVariable Long id, @AuthenticationPrincipal SecurityUser user) {
        return toDto(roundService.open(user.getId(), id));
    }

    @PostMapping("/{id}/cancel")
    public RoundDto cancel(@PathVariable Long id, @AuthenticationPrincipal SecurityUser user) {
        return toDto(roundService.cancel(user.getId(), id));
    }

    private RoundDto toDto(FundingRound round) {
        var scoring = scoringResultRepository.findByAssessment_Round_Id(round.getId()).orElse(null);
        return RoundDto.from(round, scoring);
    }
}
