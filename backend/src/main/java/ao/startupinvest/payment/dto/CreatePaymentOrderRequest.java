package ao.startupinvest.payment.dto;

public record CreatePaymentOrderRequest(String returnUrl, String cancelUrl) {
}
