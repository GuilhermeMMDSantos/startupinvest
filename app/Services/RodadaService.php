<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\RodadasInvestidores;

class RodadaService
{
    public function checkCloseRodadaStatus($rodada){
        if ($rodada->valor_objetivo != $rodada->valor_obtido)
            return (0);
        if ($rodada->estado != 'fechada')
            return (0);
        return (1);
    }

    public function updateRodadaStatus($rodada, $status)
    {
        $rodada->update([
            'estado' => $status
        ]);

        if ($status == 'sucedida'){
            RodadasInvestidores::where('fk_rodada', $rodada->id)->update([
                'status_investimento' => 3
            ]);
        }
        else if($status == 'anulada')
        {
            RodadasInvestidores::where('fk_rodada', $rodada->id)->update([
                'status_investimento' => 2
            ]);  
        }
    }

    public function getEntradaModelo(Request $request)
    {
        $attrModeloNegocio = $request->modelo_negocio;
        $isB2C = ($attrModeloNegocio == 1) ? 1 : 0;
        $isB2B = ($attrModeloNegocio == 2) ? 1 : 0;
        $isB2B2C = ($attrModeloNegocio == 3) ? 1 : 0;
        $fonteReceita = $request->input('fontes_receita', []);
        $fontIsProduto = (in_array(1, $fonteReceita)) ? 1 : 0;
        $fontIsAssinatura = (in_array(2, $fonteReceita)) ? 1 : 0;
        $fontIsPublicidade = (in_array(3, $fonteReceita)) ? 1 : 0;
        $fontIsOutra = (in_array(4, $fonteReceita)) ? 1 : 0;
        $vantagemCompetitiva = $request->input('vantagem_competitiva', []);
        $isPropriedadeIntelectual = (in_array(1, $vantagemCompetitiva))? 1 : 0;
        $isTecnologia = (in_array(2, $vantagemCompetitiva))? 1 : 0;
        $isCanaisExclusivo = (in_array(3, $vantagemCompetitiva))? 1 : 0;
        $entradaModelo = [
        'taxa_crescimento_mercado' => $request->taxa_crescimento_mercado,
        'participacao_mercado_concorrentes' => $request->participacao_mercado_concorrentes,
        'numero_concorrentes_diretos' => $request->numero_concorrentes_diretos,
        'mercado_b2c' => $isB2C,
        'mercado_b2b' => $isB2B,
        'mercado_b2b2c' => $isB2B2C,
        'tamanho_mercado_alvo' =>  $request->tamanho_mercado_alvo,
        'taxa_inflacao' => $request->taxa_inflacao,
        'taxas_juros' => $request->taxas_juros,
        'taxa_desemprego' => $request->taxa_desemprego,
        'taxa_retencao_clientes' => $request->taxa_retencao_clientes,
        'crescimento_base_clientes' => $request->crescimento_base_clientes,
        'ciclo_vida_cliente' => $request->ciclo_vida_cliente,
        'taxa_adocao_inicial' => $request->taxa_adocao_inicial,
        'recorrencia_compra' => $request->recorrencia_compra,
        'ltv' => $request->ltv,
        'ticket_medio' => $request->ticket_medio,
        'cac' => $request->cac,
        'tempo_medio_ciclo_vendas' => $request->tempo_medio_ciclo_vendas,
        'taxa_crescimento_receita' => $request->taxa_crescimento_receita,
        'duracao_media_ciclo_vendas' => $request->tempo_medio_ciclo_vendas,
        'tempo_recebimento' => $request->tempo_recebimento,
        'roi' => $request->roi,
        'receita_vendas' => $fontIsProduto,
        'receita_assinatura' => $fontIsAssinatura,
        'receita_publicidade' => $fontIsPublicidade,
        'receita_outra' => $fontIsOutra,
        'qtd_fontes_receita' => $request->qtd_fontes_receita,
        'margem_bruta' => $request->margem_bruta,
        'margem_liquida' => $request->margem_liquida,
        'despesas_operacionais_fixas' => $request->despesas_operacionais_fixas,
        'despesas_operacionais_variaveis' => $request->despesas_operacionais_variaveis,
        'propriedade_intelectual' => $isPropriedadeIntelectual,
        'tecnologia_exclusiva' => $isTecnologia,
        'acesso_canais_distribuicao' => $isCanaisExclusivo,
        'grau_automacao' => $request->grau_automacao,
        'qtd_tecnico' => $request->qtd_tecnico,
        'qtd_licenciados' => $request->qtd_licenciados,
        'qtd_mestres' => $request->qtd_mestres,
        'qtd_doutores' => $request->qtd_doutores,
        'qtd_exp_gestao' => $request->qtd_exp_gestao,
        'qtd_exp_contabilidade' => $request->qtd_exp_contabilidade,
        'qtd_exp_tecnica' => $request->qtd_exp_tecnica,
        'media_experiencia' => $request->media_experiencia,
        'tempo_trabalho_juntos' => $request->tempo_trabalho_juntos,
        'horas_trabalho_semana' => $request->horas_trabalho_semana,
        'porcentagem_tempo_projeto' => $request->porcentagem_tempo_projeto,
        'numero_reunioes_semana' => $request->numero_reunioes_semana,
        'eventos_setor' => 5,
        'tamanho_equipe' => $request->tamanho_equipe,
        'rodadas_investimento' => $request->rodadas_investimento,
        'maior_valor_captado' => $request->maior_valor_captado,
        'participou_incubacao' => $request->participacao_aceleradora,
        ];
        return $entradaModelo;
    }
}