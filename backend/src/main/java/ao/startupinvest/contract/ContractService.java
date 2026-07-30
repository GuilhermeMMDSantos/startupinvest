package ao.startupinvest.contract;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.investment.Investment;
import ao.startupinvest.user.User;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.time.Instant;
import java.util.HexFormat;
import java.util.List;

@Service
@RequiredArgsConstructor
public class ContractService {

    private final ContractRepository contractRepository;
    private final ContractSignatureRepository signatureRepository;
    private final ContractTemplateService templateService;

    @Transactional
    public Contract createForInvestment(Investment investment) {
        return contractRepository.findByInvestmentId(investment.getId()).orElseGet(() -> {
            Contract contract = new Contract();
            contract.setInvestment(investment);
            contract.setContractType(investment.getRound().getContractType());
            contract.setContent(templateService.generate(investment, investment.getRound().getContractType()));
            contract.setStatus(ContractStatus.PENDING);
            return contractRepository.save(contract);
        });
    }

    @Transactional
    public Contract sign(Long contractId, User signer, SignerRole role, String fullNameTyped, String ipAddress) {
        Contract contract = contractRepository.findById(contractId)
                .orElseThrow(() -> ApiException.notFound("Contrato não encontrado"));
        if (contract.getStatus() == ContractStatus.VOID) {
            throw ApiException.badRequest("Este contrato foi anulado");
        }
        if (signatureRepository.findByContractIdAndSignerRole(contractId, role).isPresent()) {
            throw ApiException.conflict("Este contrato já foi assinado por esta parte");
        }
        if (fullNameTyped == null || fullNameTyped.isBlank()) {
            throw ApiException.badRequest("Indique o nome completo para assinar");
        }

        ContractSignature signature = new ContractSignature();
        signature.setContract(contract);
        signature.setSigner(signer);
        signature.setSignerRole(role);
        signature.setFullNameTyped(fullNameTyped);
        signature.setSignatureHash(hash(contractId, signer.getId(), fullNameTyped));
        signature.setIpAddress(ipAddress);
        signatureRepository.save(signature);

        List<ContractSignature> signatures = signatureRepository.findByContractId(contractId);
        boolean startupSigned = signatures.stream().anyMatch(s -> s.getSignerRole() == SignerRole.STARTUP);
        boolean investorSigned = signatures.stream().anyMatch(s -> s.getSignerRole() == SignerRole.INVESTOR);

        if (startupSigned && investorSigned) {
            contract.setStatus(ContractStatus.FULLY_SIGNED);
        } else if (startupSigned) {
            contract.setStatus(ContractStatus.STARTUP_SIGNED);
        } else {
            contract.setStatus(ContractStatus.INVESTOR_SIGNED);
        }
        return contractRepository.save(contract);
    }

    public Contract getForInvestment(Long investmentId) {
        return contractRepository.findByInvestmentId(investmentId)
                .orElseThrow(() -> ApiException.notFound("Contrato ainda não gerado para este investimento"));
    }

    public Contract getById(Long id) {
        return contractRepository.findById(id).orElseThrow(() -> ApiException.notFound("Contrato não encontrado"));
    }

    public List<Contract> listForRound(Long roundId) {
        return contractRepository.findByInvestment_Round_Id(roundId);
    }

    private String hash(Long contractId, Long userId, String fullName) {
        try {
            MessageDigest digest = MessageDigest.getInstance("SHA-256");
            String payload = contractId + "|" + userId + "|" + fullName + "|" + Instant.now();
            return HexFormat.of().formatHex(digest.digest(payload.getBytes()));
        } catch (NoSuchAlgorithmException e) {
            throw new IllegalStateException(e);
        }
    }
}
