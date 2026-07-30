package ao.startupinvest.contract;

import ao.startupinvest.investment.Investment;
import org.springframework.stereotype.Service;

import java.time.ZoneOffset;
import java.time.format.DateTimeFormatter;

@Service
public class ContractTemplateService {

    private static final DateTimeFormatter DATE_FMT = DateTimeFormatter.ofPattern("dd/MM/yyyy");

    public String generate(Investment investment, ContractType type) {
        var round = investment.getRound();
        var startup = round.getStartup();
        var investor = investment.getInvestor();
        String today = java.time.Instant.now().atZone(ZoneOffset.UTC).format(DATE_FMT);

        StringBuilder sb = new StringBuilder();
        if (type == ContractType.CONVERTIBLE_NOTE) {
            sb.append("CONTRATO DE MÚTUO CONVERSÍVEL EM PARTICIPAÇÃO SOCIAL\n\n");
        } else {
            sb.append("CONTRATO DE INVESTIMENTO EM PARTICIPAÇÃO SOCIAL\n\n");
        }

        sb.append("Data: ").append(today).append("\n\n");
        sb.append("OUTORGANTE STARTUP: ").append(startup.getName())
                .append(", NIF ").append(startup.getNif()).append(" (\"Startup\").\n");
        sb.append("OUTORGANTE INVESTIDOR: ").append(investor.getFullName())
                .append(", documento ").append(investor.getDocumentType()).append(" nº ")
                .append(investor.getDocumentNumber()).append(" (\"Investidor\").\n\n");

        sb.append("CLÁUSULA 1ª - OBJETO\n");
        sb.append("O Investidor compromete-se a aportar à Startup, no âmbito da rodada de investimento nº ")
                .append(round.getId()).append(", o montante de ").append(investment.getAmount())
                .append(" USD, através da plataforma StartupInvest.\n\n");

        if (type == ContractType.CONVERTIBLE_NOTE) {
            sb.append("CLÁUSULA 2ª - CONVERSÃO\n");
            sb.append("O montante aportado converte-se automaticamente em participação social da Startup ")
                    .append("correspondente a ").append(investment.getEquityPctAllocated())
                    .append("% do capital social, na presente rodada ou na rodada de investimento subsequente, ")
                    .append("consoante o que ocorrer primeiro, nos termos definidos entre as partes.\n\n");
        } else {
            sb.append("CLÁUSULA 2ª - PARTICIPAÇÃO SOCIAL\n");
            sb.append("Em contrapartida do aporte, o Investidor recebe uma participação social da Startup ")
                    .append("correspondente a ").append(investment.getEquityPctAllocated())
                    .append("% do capital social, calculada proporcionalmente ao montante investido face ao valor ")
                    .append("objetivo total da rodada (").append(round.getTargetAmount())
                    .append(" USD) e à percentagem de capital oferecida (").append(round.getEquityOfferedPct())
                    .append("%).\n\n");
        }

        sb.append("CLÁUSULA 3ª - CONDIÇÕES DA RODADA\n");
        sb.append("Meta da rodada: ").append(round.getTargetAmount()).append(" USD. ");
        sb.append("Número máximo de investidores: ").append(round.getMaxInvestors()).append(". ");
        sb.append("Valor mínimo de investimento: ").append(round.getMinTicket()).append(" USD.\n\n");

        sb.append("CLÁUSULA 4ª - LIBERTAÇÃO DE FUNDOS\n");
        sb.append("Os fundos aportados permanecem em regime de garantia (escrow) na plataforma StartupInvest até ")
                .append("que (i) a meta da rodada seja integralmente atingida e (ii) o presente contrato seja ")
                .append("assinado por ambas as partes, momento em que serão transferidos para a conta da Startup.\n\n");

        sb.append("CLÁUSULA 5ª - ACEITAÇÃO ELETRÓNICA\n");
        sb.append("As partes reconhecem e aceitam a validade da assinatura eletrónica aposta através da ")
                .append("plataforma StartupInvest para todos os efeitos legais.\n");

        return sb.toString();
    }
}
