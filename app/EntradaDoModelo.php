<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntradaDoModelo extends Model
{
    protected $table = 'entrada_do_modelo';

    protected $fillable = [
        'id_rodada',
        'taxa_crescimento_mercado',
        'participacao_mercado_concorrentes',
        'numero_concorrentes_diretos',
        'mercado_b2c',
        'mercado_b2b',
        'mercado_b2b2c',
        'tamanho_mercado_alvo',
        'taxa_inflacao',
        'taxas_juros',
        'taxa_desemprego',
        'taxa_retencao_clientes',
        'crescimento_base_clientes',
        'ciclo_vida_cliente',
        'taxa_adocao_inicial',
        'recorrencia_compra',
        'ltv',
        'ticket_medio',
        'cac',
        'tempo_medio_ciclo_vendas',
        'taxa_crescimento_receita',
        'duracao_media_ciclo_vendas',
        'tempo_recebimento',
        'roi',
        'receita_vendas',
        'receita_assinatura',
        'receita_publicidade',
        'receita_outra',
        'qtd_fontes_receita',
        'margem_bruta',
        'margem_liquida',
        'despesas_operacionais_fixas',
        'despesas_operacionais_variaveis',
        'propriedade_intelectual',
        'tecnologia_exclusiva',
        'acesso_canais_distribuicao',
        'grau_automacao',
        'qtd_tecnico',
        'qtd_licenciados',
        'qtd_mestres',
        'qtd_doutores',
        'qtd_exp_gestao',
        'qtd_exp_contabilidade',
        'qtd_exp_tecnica',
        'media_experiencia',
        'tempo_trabalho_juntos',
        'horas_trabalho_semana',
        'porcentagem_tempo_projeto',
        'numero_reunioes_semana',
        'eventos_setor',
        'tamanho_equipe',
        'rodadas_investimento',
        'maior_valor_captado',
        'participou_incubacao',
    ];
}
