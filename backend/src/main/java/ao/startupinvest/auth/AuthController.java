package ao.startupinvest.auth;

import ao.startupinvest.auth.dto.AuthResponse;
import ao.startupinvest.auth.dto.LoginRequest;
import jakarta.validation.Valid;
import lombok.RequiredArgsConstructor;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

@RestController
@RequestMapping("/api/auth")
@RequiredArgsConstructor
public class AuthController {

    private final AuthService authService;

    @PostMapping(value = "/register/investor", consumes = "multipart/form-data")
    public AuthResponse registerInvestor(
            @RequestParam String email,
            @RequestParam String password,
            @RequestParam String fullName,
            @RequestParam String documentType,
            @RequestParam String documentNumber,
            @RequestParam(required = false) String phone,
            @RequestParam MultipartFile documentFile,
            @RequestParam MultipartFile verificationVideo) {
        return authService.registerInvestor(email, password, fullName, documentType, documentNumber, phone,
                documentFile, verificationVideo);
    }

    @PostMapping(value = "/register/startup", consumes = "multipart/form-data")
    public AuthResponse registerStartup(
            @RequestParam String email,
            @RequestParam String password,
            @RequestParam String startupName,
            @RequestParam String nif,
            @RequestParam(required = false) String sector,
            @RequestParam(required = false) String businessModel,
            @RequestParam(required = false) String shortDescription,
            @RequestParam(required = false) String website,
            @RequestParam(required = false) MultipartFile logo) {
        return authService.registerStartup(email, password, startupName, nif, sector, businessModel,
            shortDescription, website, logo);
    }

    @PostMapping("/login")
    public AuthResponse login(@Valid @RequestBody LoginRequest request) {
        return authService.login(request.email(), request.password());
    }
}
