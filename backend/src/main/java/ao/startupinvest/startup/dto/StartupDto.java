package ao.startupinvest.startup.dto;

import ao.startupinvest.startup.Startup;

public record StartupDto(Long id, String name, String nif, String sector, String businessModel,
                          String shortDescription, String website, String logoPath,
                          String status, String paypalPayoutEmail) {
    public static StartupDto from(Startup s) {
        return new StartupDto(s.getId(), s.getName(), s.getNif(), s.getSector(),
                s.getBusinessModel() != null ? s.getBusinessModel().name() : null,
                s.getShortDescription(), s.getWebsite(), s.getLogoPath(),
                s.getStatus().name(), s.getPaypalPayoutEmail());
    }
}
