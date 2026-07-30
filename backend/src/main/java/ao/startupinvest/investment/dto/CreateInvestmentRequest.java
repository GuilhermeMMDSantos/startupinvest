package ao.startupinvest.investment.dto;

import java.math.BigDecimal;

public record CreateInvestmentRequest(BigDecimal amount) {
}
