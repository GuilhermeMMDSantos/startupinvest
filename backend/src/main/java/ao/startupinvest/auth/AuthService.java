package ao.startupinvest.auth;

import ao.startupinvest.auth.dto.AuthResponse;
import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.investor.DocumentType;
import ao.startupinvest.investor.InvestorProfile;
import ao.startupinvest.investor.InvestorProfileRepository;
import ao.startupinvest.security.JwtService;
import ao.startupinvest.startup.BusinessModel;
import ao.startupinvest.startup.Startup;
import ao.startupinvest.startup.StartupRepository;
import ao.startupinvest.storage.FileStorageService;
import ao.startupinvest.user.User;
import ao.startupinvest.user.UserRepository;
import ao.startupinvest.user.UserRole;
import ao.startupinvest.user.UserStatus;
import lombok.RequiredArgsConstructor;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.multipart.MultipartFile;

@Service
@RequiredArgsConstructor
public class AuthService {

    private final UserRepository userRepository;
    private final InvestorProfileRepository investorProfileRepository;
    private final StartupRepository startupRepository;
    private final PasswordEncoder passwordEncoder;
    private final JwtService jwtService;
    private final FileStorageService fileStorageService;
    private final AuthenticationManager authenticationManager;

    @Transactional
    public AuthResponse registerInvestor(String email, String password, String fullName, String documentType,
                                          String documentNumber, String phone, MultipartFile documentFile,
                                          MultipartFile verificationVideo) {
        validateCredentials(email, password);
        DocumentType type;
        try {
            type = DocumentType.valueOf(documentType.toUpperCase());
        } catch (Exception e) {
            throw ApiException.badRequest("Tipo de documento inválido (BI ou PASSPORT)");
        }
        if (investorProfileRepository.existsByDocumentTypeAndDocumentNumber(type, documentNumber)) {
            throw ApiException.conflict("Já existe um investidor registado com este documento");
        }

        User user = new User();
        user.setEmail(email);
        user.setPasswordHash(passwordEncoder.encode(password));
        user.setRole(UserRole.INVESTOR);
        user.setStatus(UserStatus.PENDING_VERIFICATION);
        user = userRepository.save(user);

        String documentPath = fileStorageService.store(documentFile, "investors/documents");
        String videoPath = fileStorageService.store(verificationVideo, "investors/videos");

        InvestorProfile profile = new InvestorProfile();
        profile.setUser(user);
        profile.setFullName(fullName);
        profile.setDocumentType(type);
        profile.setDocumentNumber(documentNumber);
        profile.setDocumentFilePath(documentPath);
        profile.setVerificationVideoPath(videoPath);
        profile.setPhone(phone);
        investorProfileRepository.save(profile);

        return issueToken(user);
    }

    @Transactional
    public AuthResponse registerStartup(String email, String password, String startupName, String nif,
                                         String sector, String businessModel, String shortDescription,
                                         String website, MultipartFile pitchDeck, MultipartFile logo) {
        validateCredentials(email, password);
        if (startupRepository.existsByNifIgnoreCase(nif)) {
            throw ApiException.conflict("Já existe uma startup registada com este NIF");
        }

        User user = new User();
        user.setEmail(email);
        user.setPasswordHash(passwordEncoder.encode(password));
        user.setRole(UserRole.STARTUP_OWNER);
        user.setStatus(UserStatus.PENDING_VERIFICATION);
        user = userRepository.save(user);

        String deckPath = fileStorageService.store(pitchDeck, "startups/decks");

        Startup startup = new Startup();
        startup.setOwner(user);
        startup.setName(startupName);
        startup.setNif(nif);
        startup.setSector(sector);
        if (businessModel != null && !businessModel.isBlank()) {
            try {
                startup.setBusinessModel(BusinessModel.valueOf(businessModel.toUpperCase()));
            } catch (Exception ignored) {
            }
        }
        startup.setShortDescription(shortDescription);
        startup.setWebsite(website);
        startup.setPitchDeckPath(deckPath);
        if (logo != null && !logo.isEmpty()) {
            startup.setLogoPath(fileStorageService.store(logo, "startups/logos"));
        }
        startupRepository.save(startup);

        return issueToken(user);
    }

    public AuthResponse login(String email, String password) {
        Authentication auth;
        try {
            auth = authenticationManager.authenticate(new UsernamePasswordAuthenticationToken(email, password));
        } catch (Exception e) {
            throw ApiException.unauthorized("Credenciais inválidas");
        }
        User user = userRepository.findByEmailIgnoreCase(email)
                .orElseThrow(() -> ApiException.unauthorized("Credenciais inválidas"));
        if (user.getStatus() == UserStatus.SUSPENDED) {
            throw ApiException.forbidden("Conta suspensa. Contacte o suporte.");
        }
        return issueToken(user);
    }

    private void validateCredentials(String email, String password) {
        if (email == null || !email.matches("^[^@\\s]+@[^@\\s]+\\.[^@\\s]+$")) {
            throw ApiException.badRequest("Email inválido");
        }
        if (password == null || password.length() < 8) {
            throw ApiException.badRequest("A palavra-passe deve ter pelo menos 8 caracteres");
        }
        if (userRepository.existsByEmailIgnoreCase(email)) {
            throw ApiException.conflict("Já existe uma conta com este email");
        }
    }

    private AuthResponse issueToken(User user) {
        String token = jwtService.generateAccessToken(user.getId(), user.getEmail(), user.getRole().name());
        return new AuthResponse(token, user.getId(), user.getEmail(), user.getRole().name(), user.getStatus().name());
    }
}
