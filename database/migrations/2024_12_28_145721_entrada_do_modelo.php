<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EntradaDoModelo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_do_modelo', function (Blueprint $table) {
            $table->integer('id_rodada')->primary();
            $table->float('taxa_crescimento_mercado')->nullable();
            $table->float('participacao_mercado_concorrentes')->nullable();
            $table->integer('numero_concorrentes_diretos')->nullable();
            $table->boolean('mercado_b2c')->nullable();
            $table->boolean('mercado_b2b')->nullable();
            $table->boolean('mercado_b2b2c')->nullable();
            $table->float('tamanho_mercado_alvo')->nullable();
            $table->float('taxa_inflacao')->nullable();
            $table->float('taxas_juros')->nullable();
            $table->float('taxa_desemprego')->nullable();
            $table->float('taxa_retencao_clientes')->nullable();
            $table->float('crescimento_base_clientes')->nullable();
            $table->float('ciclo_vida_cliente')->nullable();
            $table->float('taxa_adocao_inicial')->nullable();
            $table->float('recorrencia_compra')->nullable();
            $table->float('ltv')->nullable();
            $table->float('ticket_medio')->nullable();
            $table->float('cac')->nullable();
            $table->float('tempo_medio_ciclo_vendas')->nullable();
            $table->float('taxa_crescimento_receita')->nullable();
            $table->float('duracao_media_ciclo_vendas')->nullable();
            $table->float('tempo_recebimento')->nullable();
            $table->float('roi')->nullable();
            $table->float('receita_vendas')->nullable();
            $table->float('receita_assinatura')->nullable();
            $table->float('receita_publicidade')->nullable();
            $table->float('receita_outra')->nullable();
            $table->integer('qtd_fontes_receita')->nullable();
            $table->float('margem_bruta')->nullable();
            $table->float('margem_liquida')->nullable();
            $table->float('despesas_operacionais_fixas')->nullable();
            $table->float('despesas_operacionais_variaveis')->nullable();
            $table->boolean('propriedade_intelectual')->nullable();
            $table->boolean('tecnologia_exclusiva')->nullable();
            $table->boolean('acesso_canais_distribuicao')->nullable();
            $table->float('grau_automacao')->nullable();
            $table->integer('qtd_tecnico')->nullable();
            $table->integer('qtd_licenciados')->nullable();
            $table->integer('qtd_mestres')->nullable();
            $table->integer('qtd_doutores')->nullable();
            $table->integer('qtd_exp_gestao')->nullable();
            $table->integer('qtd_exp_contabilidade')->nullable();
            $table->integer('qtd_exp_tecnica')->nullable();
            $table->float('media_experiencia')->nullable();
            $table->float('tempo_trabalho_juntos')->nullable();
            $table->float('horas_trabalho_semana')->nullable();
            $table->float('porcentagem_tempo_projeto')->nullable();
            $table->integer('numero_reunioes_semana')->nullable();
            $table->integer('eventos_setor')->nullable();
            $table->integer('tamanho_equipe')->nullable();
            $table->integer('rodadas_investimento')->nullable();
            $table->float('maior_valor_captado')->nullable();
            $table->boolean('participou_incubacao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_do_modelo');
    }
}
