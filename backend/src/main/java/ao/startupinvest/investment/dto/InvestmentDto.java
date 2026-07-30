package ao.startupinvest.investment.dto;

import ao.startupinvest.investment.Investment;

import java.math.BigDecimal;
import java.time.Instant;

public record InvestmentDto(Long id, Long roundId, String startupName, Long investorId, String investorName,
                             BigDecimal amount, BigDecimal equityPctAllocated, String status, Instant createdAt) {
    public static InvestmentDto from(Investment i) {
        return new InvestmentDto(i.getId(), i.getRound().getId(), i.getRound().getStartup().getName(),
                i.getInvestor().getId(), i.getInvestor().getFullName(), i.getAmount(), i.getEquityPctAllocated(),
                i.getStatus().name(), i.getCreatedAt());
    }
}
