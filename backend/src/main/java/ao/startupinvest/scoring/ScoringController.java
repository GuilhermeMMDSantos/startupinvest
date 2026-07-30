package ao.startupinvest.scoring;

import ao.startupinvest.scoring.dto.AssessmentRequest;
import ao.startupinvest.scoring.dto.ScoringResultDto;
import ao.startupinvest.security.SecurityUser;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/rounds/{roundId}/assessment")
@RequiredArgsConstructor
public class ScoringController {

    private final ScoringService scoringService;

    @PostMapping
    public ScoringResultDto submit(@PathVariable Long roundId, @RequestBody AssessmentRequest request,
                                    @AuthenticationPrincipal SecurityUser user) {
        return ScoringResultDto.from(scoringService.submitAssessment(user.getId(), roundId, request));
    }

    @GetMapping
    public ScoringResultDto get(@PathVariable Long roundId) {
        return ScoringResultDto.from(scoringService.getForRound(roundId));
    }
}
