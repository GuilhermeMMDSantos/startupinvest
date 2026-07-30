package ao.startupinvest.payment.dto;

import ao.startupinvest.payment.Payment;

import java.math.BigDecimal;
import java.time.Instant;

public record PaymentDto(Long id, Long investmentId, String type, String provider, String providerOrderId,
                          BigDecimal amount, String currency, String status, Instant createdAt) {
    public static PaymentDto from(Payment p) {
        return new PaymentDto(p.getId(), p.getInvestment() != null ? p.getInvestment().getId() : null,
                p.getType().name(), p.getProvider(), p.getProviderOrderId(), p.getAmount(), p.getCurrency(),
                p.getStatus().name(), p.getCreatedAt());
    }
}
