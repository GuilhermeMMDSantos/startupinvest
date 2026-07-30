package ao.startupinvest.admin.dto;

import java.math.BigDecimal;

public record AdminStatsDto(long totalUsers, long totalInvestors, long pendingInvestorVerifications,
                             long totalStartups, long pendingStartupApprovals, long openRounds,
                             long closedSuccessRounds, BigDecimal totalRaised, long totalInvestments,
                             long pendingContracts) {
}
