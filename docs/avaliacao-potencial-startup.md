# Avaliacao de Potencial da Startup

Este projecto nao usa um modelo de IA treinado para prever o sucesso de uma startup. O que existe atualmente e um **motor estatistico de scoring** que calcula um indice de potencial de crescimento com base numa grelha de metricas ponderadas.

## Onde isto vive no codigo

- Motor de scoring: [backend/src/main/java/ao/startupinvest/scoring/ScoringEngine.java](../backend/src/main/java/ao/startupinvest/scoring/ScoringEngine.java)
- Servico que recebe o questionario e grava o resultado: [backend/src/main/java/ao/startupinvest/scoring/ScoringService.java](../backend/src/main/java/ao/startupinvest/scoring/ScoringService.java)
- Questionario preenchido pela startup: [backend/src/main/java/ao/startupinvest/scoring/StartupAssessment.java](../backend/src/main/java/ao/startupinvest/scoring/StartupAssessment.java)
- Endpoint HTTP: [backend/src/main/java/ao/startupinvest/scoring/ScoringController.java](../backend/src/main/java/ao/startupinvest/scoring/ScoringController.java)
- Resultado devolvido para a interface: [backend/src/main/java/ao/startupinvest/scoring/dto/ScoringResultDto.java](../backend/src/main/java/ao/startupinvest/scoring/dto/ScoringResultDto.java)

## Como funciona

1. A startup cria uma rodada e depois submete um questionario de avaliacao enquanto a rodada ainda esta em rascunho.
2. O frontend envia os dados para `POST /api/rounds/{roundId}/assessment`.
3. O backend guarda as respostas num `StartupAssessment`.
4. O `ScoringEngine` percorre uma lista fixa de metricas, por exemplo:
   - mercado
   - tracao
   - financeiro
   - equipa
   - moat ou dificuldade de replica
   - contexto macroeconomico
5. Cada metrica e normalizada para uma escala de `0` a `100`.
6. Cada metrica recebe um peso diferente e o resultado final e calculado por media ponderada.
7. O resultado gera:
   - `growthPotentialScore`
   - `seriesBLikelihood` com os niveis `BAIXO`, `MEDIO` ou `ALTO`
   - listas de `strengths` e `weaknesses`

## Regras principais do score

No motor atual existem dois limiares importantes:

- abaixo de `40` => `BAIXO`
- entre `40` e `75` => `MEDIO`
- a partir de `75` => `ALTO`

O motor tambem considera a relacao `LTV / CAC`, que entra como um fator adicional no calculo final.

## O que a plataforma mostra

O frontend mostra este resultado em:

- lista de rodadas
- pagina de detalhe da rodada
- pagina de gestao da rodada pela startup
- badges de scoring nos cards e nas paginas de detalhe

Os ficheiros mais relevantes sao:

- [frontend/src/components/ScoringBadge.tsx](../frontend/src/components/ScoringBadge.tsx)
- [frontend/src/components/RoundCard.tsx](../frontend/src/components/RoundCard.tsx)
- [frontend/src/pages/RoundDetail.tsx](../frontend/src/pages/RoundDetail.tsx)
- [frontend/src/pages/startup/RoundAssessment.tsx](../frontend/src/pages/startup/RoundAssessment.tsx)
- [frontend/src/pages/startup/RoundManage.tsx](../frontend/src/pages/startup/RoundManage.tsx)

## Importante

Este scoring deve ser visto como uma **ferramenta de apoio a decisao**, nao como uma IA autonoma. Ele ajuda a padronizar a analise do potencial da startup, mas nao substitui a revisao do administrador ou a analise humana dos investidores.

## Depois irei vou evoluir para a criacao do meu proprio modelo de rede neural
