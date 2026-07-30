package ao.startupinvest.contract.dto;

import ao.startupinvest.contract.Contract;

import java.time.Instant;

public record ContractDto(Long id, Long investmentId, String contractType, String content, String status,
                           Instant createdAt) {
    public static ContractDto from(Contract c) {
        return new ContractDto(c.getId(), c.getInvestment().getId(), c.getContractType().name(), c.getContent(),
                c.getStatus().name(), c.getCreatedAt());
    }
}
