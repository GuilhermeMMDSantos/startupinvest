<?php

namespace App\Services;

class StartupPotentialScoringService
{
    private const WEAKNESS_THRESHOLD = 40;
    private const STRENGTH_THRESHOLD = 75;
    private const LTV_CAC_MAX = 5.0;
    private const LTV_CAC_WEIGHT = 5;

    private const METRICS = [
        ['key' => 'taxa_crescimento_mercado', 'display' => 'Taxa_crescimento_mercado', 'weight' => 6, 'min' => 0, 'max' => 50, 'higherIsBetter' => true],
        ['key' => 'participacao_mercado_concorrentes', 'display' => 'Participacao_mercado_concorrentes', 'weight' => 5, 'min' => 0, 'max' => 100, 'higherIsBetter' => false],
        ['key' => 'numero_concorrentes_diretos', 'display' => 'Numero_concorrentes_diretos', 'weight' => 4, 'min' => 0, 'max' => 20, 'higherIsBetter' => false],
        ['key' => 'tamanho_mercado_alvo', 'display' => 'Tamanho_mercado_alvo', 'weight' => 5, 'min' => 0, 'max' => 5000000000, 'higherIsBetter' => true],

        ['key' => 'taxa_retencao_clientes', 'display' => 'Taxa_retencao_clientes', 'weight' => 5, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'crescimento_base_clientes', 'display' => 'Crescimento_base_clientes', 'weight' => 4, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'taxa_adocao_inicial', 'display' => 'Taxa_adocao_inicial', 'weight' => 3, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'recorrencia_compra', 'display' => 'Recorrencia_compra', 'weight' => 3, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],

        ['key' => 'taxa_crescimento_receita', 'display' => 'Taxa_crescimento_receita', 'weight' => 6, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'roi', 'display' => 'ROI', 'weight' => 6, 'min' => -50, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'margem_bruta', 'display' => 'Margem_bruta', 'weight' => 5, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'margem_liquida', 'display' => 'Margem_liquida', 'weight' => 4, 'min' => -20, 'max' => 50, 'higherIsBetter' => true],
        ['key' => 'tempo_recebimento', 'display' => 'Tempo_recebimento', 'weight' => 2, 'min' => 0, 'max' => 90, 'higherIsBetter' => false],
        ['key' => 'qtd_fontes_receita', 'display' => 'Qtd_fontes_receita', 'weight' => 2, 'min' => 0, 'max' => 4, 'higherIsBetter' => true],

        ['key' => 'media_experiencia', 'display' => 'Media_experiencia', 'weight' => 5, 'min' => 0, 'max' => 15, 'higherIsBetter' => true],
        ['key' => 'tamanho_equipe', 'display' => 'Tamanho_equipe', 'weight' => 3, 'min' => 1, 'max' => 15, 'higherIsBetter' => true],
        ['key' => 'qtd_exp_gestao', 'display' => 'Qtd_exp_gestao', 'weight' => 3, 'min' => 0, 'max' => 5, 'higherIsBetter' => true],
        ['key' => 'qtd_tecnico', 'display' => 'Qtd_tecnico', 'weight' => 3, 'min' => 0, 'max' => 5, 'higherIsBetter' => true],
        ['key' => 'horas_trabalho_semana', 'display' => 'Horas_trabalho_semana', 'weight' => 3, 'min' => 0, 'max' => 60, 'higherIsBetter' => true],
        ['key' => 'tempo_trabalho_juntos', 'display' => 'Tempo_trabalho_juntos', 'weight' => 3, 'min' => 0, 'max' => 5, 'higherIsBetter' => true],

        ['key' => 'propriedade_intelectual', 'display' => 'Propriedade_intelectual', 'weight' => 2, 'min' => 0, 'max' => 1, 'higherIsBetter' => true],
        ['key' => 'tecnologia_exclusiva', 'display' => 'Tecnologia_exclusiva', 'weight' => 2, 'min' => 0, 'max' => 1, 'higherIsBetter' => true],
        ['key' => 'acesso_canais_distribuicao', 'display' => 'Acesso_canais_distribuicao', 'weight' => 2, 'min' => 0, 'max' => 1, 'higherIsBetter' => true],
        ['key' => 'grau_automacao', 'display' => 'Grau_automacao', 'weight' => 3, 'min' => 0, 'max' => 100, 'higherIsBetter' => true],
        ['key' => 'participou_incubacao', 'display' => 'Participou_incubacao', 'weight' => 2, 'min' => 0, 'max' => 1, 'higherIsBetter' => true],
        ['key' => 'rodadas_investimento', 'display' => 'Rodadas_investimento', 'weight' => 2, 'min' => 0, 'max' => 3, 'higherIsBetter' => true],
        ['key' => 'taxa_inflacao', 'display' => 'Taxa_inflacao', 'weight' => 1, 'min' => 0, 'max' => 50, 'higherIsBetter' => false],
        ['key' => 'taxas_juros', 'display' => 'Taxas_juros', 'weight' => 0.5, 'min' => 0, 'max' => 50, 'higherIsBetter' => false],
        ['key' => 'taxa_desemprego', 'display' => 'Taxa_desemprego', 'weight' => 0.5, 'min' => 0, 'max' => 50, 'higherIsBetter' => false],
    ];

    public function evaluate(array $entradaModelo): object
    {
        $totalWeight = 0.0;
        $weightedScore = 0.0;
        $weaknesses = [];
        $strengths = [];

        foreach (self::METRICS as $metric) {
            $rawValue = (float) ($entradaModelo[$metric['key']] ?? 0);
            $score = $this->normalize($rawValue, $metric['min'], $metric['max'], $metric['higherIsBetter']);

            $weightedScore += $score * $metric['weight'];
            $totalWeight += $metric['weight'];

            $this->classify($weaknesses, $strengths, $metric['display'], $rawValue, $score);
        }

        $ltv = (float) ($entradaModelo['ltv'] ?? 0);
        $cac = (float) ($entradaModelo['cac'] ?? 0);
        $ltvCacRatio = $cac > 0 ? $ltv / $cac : ($ltv > 0 ? self::LTV_CAC_MAX : 0);
        $ltvCacScore = $this->normalize($ltvCacRatio, 0, self::LTV_CAC_MAX, true);

        $weightedScore += $ltvCacScore * self::LTV_CAC_WEIGHT;
        $totalWeight += self::LTV_CAC_WEIGHT;

        $this->classify($weaknesses, $strengths, 'LTV', $ltv, $ltvCacScore);
        $this->classify($weaknesses, $strengths, 'CAC', $cac, $ltvCacScore);

        return (object) [
            'growth_potential' => $totalWeight > 0 ? round($weightedScore / $totalWeight) : 0,
            'weaknesses' => $weaknesses,
            'strengths' => $strengths,
        ];
    }

    private function normalize(float $value, float $min, float $max, bool $higherIsBetter): float
    {
        $clamped = max($min, min($max, $value));
        $ratio = $max === $min ? 1.0 : ($clamped - $min) / ($max - $min);
        $score = $ratio * 100;

        return $higherIsBetter ? $score : 100 - $score;
    }

    private function classify(array &$weaknesses, array &$strengths, string $display, float $rawValue, float $score): void
    {
        if ($score < self::WEAKNESS_THRESHOLD) {
            $weaknesses[$display] = $rawValue;
        } elseif ($score >= self::STRENGTH_THRESHOLD) {
            $strengths[$display] = $rawValue;
        }
    }
}
