package ao.startupinvest.startup.dto;

public record UpdateStartupRequest(String sector, String businessModel, String shortDescription,
                                    String website, String paypalPayoutEmail) {
}
