package ao.startupinvest.payment;

import ao.startupinvest.common.exception.ApiException;
import ao.startupinvest.config.AppProperties;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.stereotype.Component;
import org.springframework.web.client.RestClient;

import java.math.BigDecimal;
import java.util.Base64;
import java.util.List;
import java.util.Map;

/**
 * Thin wrapper around the PayPal REST API (sandbox by default via app.paypal.base-url).
 * Handles investor deposits into the platform's PayPal account (escrow) via Orders v2,
 * and startup disbursements once a round is fully funded and signed via Payouts.
 */
@Component
@RequiredArgsConstructor
@Slf4j
public class PayPalClient {

    private final AppProperties appProperties;
    private final ObjectMapper objectMapper = new ObjectMapper();

    private RestClient client() {
        return RestClient.builder().baseUrl(appProperties.getPaypal().getBaseUrl()).build();
    }

    private String accessToken() {
        String credentials = appProperties.getPaypal().getClientId() + ":" + appProperties.getPaypal().getClientSecret();
        String basic = Base64.getEncoder().encodeToString(credentials.getBytes());
        try {
            String body = client().post()
                    .uri("/v1/oauth2/token")
                    .header(HttpHeaders.AUTHORIZATION, "Basic " + basic)
                    .header(HttpHeaders.CONTENT_TYPE, MediaType.APPLICATION_FORM_URLENCODED_VALUE)
                    .body("grant_type=client_credentials")
                    .retrieve()
                    .body(String.class);
            return objectMapper.readTree(body).get("access_token").asText();
        } catch (Exception e) {
            throw ApiException.badRequest("Falha ao autenticar com o PayPal: " + e.getMessage());
        }
    }

    public record OrderResult(String orderId, String approveUrl, String rawResponse) {
    }

    public OrderResult createOrder(BigDecimal amount, String currency, String returnUrl, String cancelUrl) {
        Map<String, Object> payload = Map.of(
                "intent", "CAPTURE",
                "purchase_units", List.of(Map.of(
                        "amount", Map.of("currency_code", currency, "value", amount.setScale(2, java.math.RoundingMode.HALF_UP).toString())
                )),
                "application_context", Map.of(
                        "return_url", returnUrl,
                        "cancel_url", cancelUrl,
                        "user_action", "PAY_NOW"
                )
        );
        String body = client().post()
                .uri("/v2/checkout/orders")
                .header(HttpHeaders.AUTHORIZATION, "Bearer " + accessToken())
                .contentType(MediaType.APPLICATION_JSON)
                .body(payload)
                .retrieve()
                .body(String.class);
        try {
            JsonNode json = objectMapper.readTree(body);
            String id = json.get("id").asText();
            String approveUrl = null;
            for (JsonNode link : json.get("links")) {
                if ("approve".equals(link.get("rel").asText())) {
                    approveUrl = link.get("href").asText();
                }
            }
            return new OrderResult(id, approveUrl, body);
        } catch (Exception e) {
            throw ApiException.badRequest("Resposta inesperada do PayPal ao criar ordem: " + e.getMessage());
        }
    }

    public record CaptureResult(boolean completed, String rawResponse) {
    }

    public CaptureResult captureOrder(String orderId) {
        String body = client().post()
                .uri("/v2/checkout/orders/{id}/capture", orderId)
                .header(HttpHeaders.AUTHORIZATION, "Bearer " + accessToken())
                .contentType(MediaType.APPLICATION_JSON)
                .retrieve()
                .body(String.class);
        try {
            JsonNode json = objectMapper.readTree(body);
            String status = json.get("status").asText();
            return new CaptureResult("COMPLETED".equals(status), body);
        } catch (Exception e) {
            throw ApiException.badRequest("Resposta inesperada do PayPal ao capturar pagamento: " + e.getMessage());
        }
    }

    public record PayoutResult(String batchId, String rawResponse) {
    }

    public PayoutResult sendPayout(String recipientEmail, BigDecimal amount, String currency, String note, String senderBatchId) {
        Map<String, Object> payload = Map.of(
                "sender_batch_header", Map.of(
                        "sender_batch_id", senderBatchId,
                        "email_subject", "Pagamento StartupInvest",
                        "email_message", note
                ),
                "items", List.of(Map.of(
                        "recipient_type", "EMAIL",
                        "amount", Map.of("value", amount.setScale(2, java.math.RoundingMode.HALF_UP).toString(), "currency", currency),
                        "receiver", recipientEmail,
                        "note", note,
                        "sender_item_id", senderBatchId
                ))
        );
        String body = client().post()
                .uri("/v1/payments/payouts")
                .header(HttpHeaders.AUTHORIZATION, "Bearer " + accessToken())
                .contentType(MediaType.APPLICATION_JSON)
                .body(payload)
                .retrieve()
                .body(String.class);
        try {
            JsonNode json = objectMapper.readTree(body);
            String batchId = json.get("batch_header").get("payout_batch_id").asText();
            return new PayoutResult(batchId, body);
        } catch (Exception e) {
            throw ApiException.badRequest("Resposta inesperada do PayPal ao criar payout: " + e.getMessage());
        }
    }
}
