package ao.startupinvest.startup;

import ao.startupinvest.startup.dto.StartupDto;
import ao.startupinvest.startup.dto.TeamMemberDto;
import ao.startupinvest.startup.dto.TeamMemberRequest;
import ao.startupinvest.startup.dto.UpdateStartupRequest;
import ao.startupinvest.security.SecurityUser;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.security.core.annotation.AuthenticationPrincipal;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/startups")
@RequiredArgsConstructor
public class StartupController {

    private final StartupService startupService;

    @GetMapping("/me")
    public StartupDto me(@AuthenticationPrincipal SecurityUser user) {
        return StartupDto.from(startupService.getByOwner(user.getId()));
    }

    @PutMapping("/me")
    public StartupDto update(@RequestBody UpdateStartupRequest request, @AuthenticationPrincipal SecurityUser user) {
        return StartupDto.from(startupService.update(user.getId(), request));
    }

    @GetMapping("/{id}/public")
    public StartupDto getPublic(@PathVariable Long id) {
        return StartupDto.from(startupService.getPublic(id));
    }

    @GetMapping("/me/team")
    public List<TeamMemberDto> myTeam(@AuthenticationPrincipal SecurityUser user) {
        Long startupId = startupService.getByOwner(user.getId()).getId();
        return startupService.listTeam(startupId).stream().map(TeamMemberDto::from).toList();
    }

    @PostMapping("/me/team")
    public TeamMemberDto addTeam(@Valid @RequestBody TeamMemberRequest request, @AuthenticationPrincipal SecurityUser user) {
        return TeamMemberDto.from(startupService.addTeamMember(user.getId(), request));
    }

    @DeleteMapping("/me/team/{memberId}")
    public void removeTeam(@PathVariable Long memberId, @AuthenticationPrincipal SecurityUser user) {
        startupService.removeTeamMember(user.getId(), memberId);
    }
}
