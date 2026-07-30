package ao.startupinvest.investor.dto;

import ao.startupinvest.investor.InvestorProfile;

public record InvestorProfileDto(Long id, Long userId, String email, String fullName, String documentType,
                                  String documentNumber, String documentFilePath, String verificationVideoPath,
                                  String phone, String verificationStatus) {
    public static InvestorProfileDto from(InvestorProfile p) {
        return new InvestorProfileDto(p.getId(), p.getUser().getId(), p.getUser().getEmail(), p.getFullName(),
                p.getDocumentType().name(), p.getDocumentNumber(), p.getDocumentFilePath(),
                p.getVerificationVideoPath(), p.getPhone(), p.getVerificationStatus().name());
    }
}
