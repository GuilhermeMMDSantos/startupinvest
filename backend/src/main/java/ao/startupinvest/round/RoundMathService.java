package ao.startupinvest.round;

import ao.startupinvest.common.exception.ApiException;

import java.math.BigDecimal;
import java.math.RoundingMode;
import org.springframework.stereotype.Service;

/**
 * Rules ported from the original platform's ClassRodadas/PaymentService/RodadaService:
 * minimum ticket per investor, equity split proportional to amount invested, and the
 * guardrails that keep a round always closeable to exactly its target (no dust left over
 * below the minimum ticket).
 */
@Service
public class RoundMathService {

    public void validateRoundCreation(BigDecimal targetAmount, BigDecimal equityOfferedPct, int maxInvestors) {
        if (targetAmount == null || targetAmount.compareTo(BigDecimal.ZERO) <= 0) {
            throw ApiException.badRequest("O valor da meta deve ser maior que zero");
        }
        if (equityOfferedPct == null || equityOfferedPct.compareTo(BigDecimal.ZERO) <= 0
                || equityOfferedPct.compareTo(BigDecimal.valueOf(100)) > 0) {
            throw ApiException.badRequest("A percentagem de capital oferecida deve estar entre 0 e 100");
        }
        if (maxInvestors < 2) {
            throw ApiException.badRequest("O número máximo de investidores não pode ser menor que 2");
        }
    }

    public BigDecimal computeMinTicket(BigDecimal targetAmount, int maxInvestors) {
        return targetAmount.divide(BigDecimal.valueOf(maxInvestors), 2, RoundingMode.HALF_UP);
    }

    public BigDecimal computeEquityAllocation(BigDecimal amount, BigDecimal targetAmount, BigDecimal equityOfferedPct) {
        return amount.multiply(equityOfferedPct)
                .divide(targetAmount, 4, RoundingMode.HALF_UP);
    }

    public void validateInvestmentAmount(FundingRound round, BigDecimal amount, long confirmedInvestorCount) {
        if (round.getStatus() != RoundStatus.OPEN) {
            throw ApiException.badRequest("Esta rodada não está aberta a investimentos");
        }
        if (amount == null || amount.compareTo(BigDecimal.ZERO) <= 0) {
            throw ApiException.badRequest("O valor a investir deve ser maior que zero");
        }
        if (confirmedInvestorCount >= round.getMaxInvestors()) {
            throw ApiException.badRequest("A rodada já atingiu o número máximo de investidores");
        }
        if (amount.compareTo(round.getMinTicket()) < 0) {
            throw ApiException.badRequest(
                    "O valor a investir deve ser maior ou igual ao valor mínimo da rodada (" + round.getMinTicket() + ")");
        }
        if (amount.compareTo(round.getTargetAmount()) == 0) {
            throw ApiException.badRequest("Um único investidor não pode investir a totalidade do valor procurado");
        }
        BigDecimal projectedTotal = round.getAmountRaised().add(amount);
        if (projectedTotal.compareTo(round.getTargetAmount()) > 0) {
            throw ApiException.badRequest("O valor obtido mais o valor a investir ultrapassa o valor objetivo da rodada");
        }
        BigDecimal remaining = round.getTargetAmount().subtract(projectedTotal);
        if (remaining.compareTo(BigDecimal.ZERO) != 0 && remaining.compareTo(round.getMinTicket()) < 0) {
            throw ApiException.badRequest(
                    "O valor remanescente da rodada após este investimento ficaria abaixo do valor mínimo permitido; "
                            + "ajuste o montante para deixar o restante em zero ou acima do mínimo");
        }
    }
}
