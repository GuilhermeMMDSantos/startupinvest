package ao.startupinvest.round.dto;

import java.math.BigDecimal;

public record CreateRoundRequest(BigDecimal targetAmount, BigDecimal equityOfferedPct, Integer maxInvestors,
                                  String contractType) {
}
