package ao.startupinvest.contract.dto;

import jakarta.validation.constraints.NotBlank;

public record SignContractRequest(@NotBlank String fullNameTyped) {
}
