package ao.startupinvest.contract;

import ao.startupinvest.user.User;
import jakarta.persistence.*;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.time.Instant;

@Entity
@Table(name = "contract_signatures")
@Getter
@Setter
@NoArgsConstructor
public class ContractSignature {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "contract_id", nullable = false)
    private Contract contract;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "signer_user_id", nullable = false)
    private User signer;

    @Enumerated(EnumType.STRING)
    @Column(name = "signer_role", nullable = false, length = 20)
    private SignerRole signerRole;

    @Column(name = "full_name_typed", nullable = false, length = 180)
    private String fullNameTyped;

    @Column(name = "signature_hash", nullable = false, length = 128)
    private String signatureHash;

    @Column(name = "signed_at", nullable = false)
    private Instant signedAt = Instant.now();

    @Column(name = "ip_address", length = 64)
    private String ipAddress;
}
