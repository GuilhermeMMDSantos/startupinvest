package ao.startupinvest.config;

import lombok.Data;
import org.springframework.boot.context.properties.ConfigurationProperties;

import java.util.List;

@Data
@ConfigurationProperties(prefix = "app")
public class AppProperties {

    private Jwt jwt = new Jwt();
    private Storage storage = new Storage();
    private Cors cors = new Cors();
    private Paypal paypal = new Paypal();
    private Admin admin = new Admin();

    @Data
    public static class Jwt {
        private String secret;
        private long accessTokenMinutes;
        private long refreshTokenDays;
    }

    @Data
    public static class Storage {
        private String root;
    }

    @Data
    public static class Cors {
        private List<String> allowedOrigins;
    }

    @Data
    public static class Paypal {
        private String baseUrl;
        private String clientId;
        private String clientSecret;
        private String currency;
    }

    @Data
    public static class Admin {
        private String seedEmail;
        private String seedPassword;
    }
}
