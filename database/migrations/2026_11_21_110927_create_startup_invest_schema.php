<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStartupInvestSchema extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('password');
            $table->enum('estado', ['espera', 'regeitado', 'aceite'])->default('espera');
            $table->enum('tipo', ['startup', 'investidor', 'admin'])->default('startup');
            $table->string('code_user', 1000);
            $table->timestamps();
        });

        Schema::create('areas_formacao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('cargos_executivo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sigla');
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::create('certificados_formacao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('fases_desenvolvimento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('setores_economico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->timestamps();
        });

        Schema::create('funcoes_experiencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->enum('outro', ['yes', 'no'])->default('no');
            $table->timestamps();
        });

        Schema::create('instituicoes_experincia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->enum('outro', ['yes', 'no'])->default('no');
            $table->timestamps();
        });

        Schema::create('investidores', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_user')->primary();
            $table->string('nome_completo');
            $table->string('bilhete_identidade');
            $table->string('foto');
            $table->string('video_investidor');
            $table->timestamps();

            $table->foreign('fk_user')->references('id')->on('users');
        });

        Schema::create('startups', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_user')->primary();
            $table->string('nome');
            $table->string('nif');
            $table->unsignedInteger('fk_setor_economico');
            $table->unsignedInteger('fk_fase_desenvolvimento');
            $table->string('pitch_elevator', 1000);
            $table->string('pitch_deck')->nullable();
            $table->string('mvp');
            $table->string('logotipo');
            $table->enum('estado_busca_invest', ['sim', 'nao'])->default('nao');
            $table->timestamps();

            $table->foreign('fk_user')->references('id')->on('users');
            $table->foreign('fk_setor_economico')->references('id')->on('setores_economico');
            $table->foreign('fk_fase_desenvolvimento')->references('id')->on('fases_desenvolvimento');
        });

        Schema::create('investidores_da_startup', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->string('nome');
            $table->string('sobrenome')->nullable();
            $table->unsignedBigInteger('fk_startup');
            $table->integer('porcentagem_na_startup');
            $table->enum('tipo_entidade', ['Física', 'Jurídica'])->default('Física');
            $table->timestamps();

            $table->foreign('fk_startup')->references('fk_user')->on('startups');
        });

        Schema::create('membros_equipa_startup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('sobrenome');
            $table->unsignedBigInteger('fk_startup');
            $table->string('img')->nullable();
            $table->timestamps();

            $table->foreign('fk_startup')->references('fk_user')->on('startups');
        });

        Schema::create('membrosequipa_cargosexecutivo_m_m', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_cargo_executivo');
            $table->unsignedInteger('fk_membro_equipa');
            $table->timestamps();

            $table->foreign('fk_cargo_executivo')->references('id')->on('cargos_executivo');
            $table->foreign('fk_membro_equipa')->references('id')->on('membros_equipa_startup');
        });

        Schema::create('experiencia_membro_equipa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_membro_equipa');
            $table->unsignedBigInteger('fk_funcao');
            $table->unsignedBigInteger('fk_instituicao');
            $table->timestamps();

            $table->foreign('fk_membro_equipa')->references('id')->on('membros_equipa_startup');
            $table->foreign('fk_funcao')->references('id')->on('funcoes_experiencia');
            $table->foreign('fk_instituicao')->references('id')->on('instituicoes_experincia');
        });

        Schema::create('formacao_membro_equipa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('fk_membro_equipa');
            $table->unsignedBigInteger('fk_area_formacao');
            $table->unsignedBigInteger('fk_certificado_formacao');
            $table->timestamps();

            $table->foreign('fk_membro_equipa')->references('id')->on('membros_equipa_startup');
            $table->foreign('fk_area_formacao')->references('id')->on('areas_formacao');
            $table->foreign('fk_certificado_formacao')->references('id')->on('certificados_formacao');
        });

        Schema::create('mensagens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_remetente');
            $table->unsignedBigInteger('fk_destinatario');
            $table->string('conteudo', 10000);
            $table->enum('vista', ['sim', 'nao'])->default('nao');
            $table->timestamps();

            $table->foreign('fk_remetente')->references('id')->on('users');
            $table->foreign('fk_destinatario')->references('id')->on('users');
        });

        Schema::create('rodadas_investimento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('fk_startup');
            $table->decimal('valor_objetivo', 12, 2);
            $table->decimal('valor_objetivo_sem_taxa', 12, 2);
            $table->decimal('valor_obtido', 12, 2);
            $table->decimal('oferta_acoes', 4, 2);
            $table->integer('max_investidores');
            $table->decimal('valor_minimo_investimento', 12, 2);
            $table->enum('estado', ['aberta', 'fechada', 'anulada', 'sucedida'])->default('aberta')->nullable();
            $table->timestamp('data_limite')->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('fk_startup')->references('fk_user')->on('startups');
        });

        Schema::create('rodadas_investidores', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_rodada');
            $table->unsignedBigInteger('fk_investidor');
            $table->decimal('valor_investido', 12, 2);
            $table->decimal('acoes_adquirida', 3, 2);
            $table->string('contrato_mutou')->nullable();
            $table->smallInteger('status_contrato_investidor')->nullable()->default(1);
            $table->smallInteger('status_contrato_startup')->nullable()->default(1);
            $table->smallInteger('status_investimento');
            $table->enum('contrato_mutou_aprovado', ['aguarda', 'aprovado'])->nullable();
            $table->timestamps();

            $table->foreign('fk_rodada')->references('id')->on('rodadas_investimento');
            $table->foreign('fk_investidor')->references('fk_user')->on('investidores');
        });

        Schema::create('finalidades_investimento', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fk_rodada');
            $table->string('item');
            $table->timestamps();

            $table->foreign('fk_rodada')->references('id')->on('rodadas_investimento');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('message');
            $table->unsignedBigInteger('fk_user_distination');
            $table->unsignedBigInteger('fk_user_origin');
            $table->enum('tipo', ['ver_pitch', 'foi_investido', 'talk_apos_pitch'])->default('ver_pitch');
            $table->enum('status', ['nao_visto', 'visto', 'clicado'])->default('nao_visto');
            $table->timestamps();

            $table->foreign('fk_user_distination')->references('id')->on('users');
            $table->foreign('fk_user_origin')->references('id')->on('users');
        });

        Schema::create('permissoes_ver_pitch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_startup');
            $table->unsignedBigInteger('fk_investidor');
            $table->unsignedInteger('fk_rodada');
            $table->dateTime('data_permissao')->default('1997-03-25 00:00:00');
            $table->enum('estado', ['espera', 'ignorado', 'ativo', 'vencido'])->default('espera');
            $table->timestamps();

            $table->foreign('fk_startup')->references('fk_user')->on('startups');
            $table->foreign('fk_investidor')->references('fk_user')->on('investidores');
            $table->foreign('fk_rodada')->references('id')->on('rodadas_investimento');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_number', 50)->nullable();
            $table->string('item_name')->nullable();
            $table->decimal('item_price', 10, 2)->nullable();
            $table->string('order_id', 50);
            $table->unsignedBigInteger('fk_payer');
            $table->string('payment_source', 50)->nullable();
            $table->string('payment_source_card_last_digits', 4)->nullable();
            $table->string('payment_source_card_expiry', 10)->nullable();
            $table->string('payment_source_card_brand', 25)->nullable();
            $table->string('payment_status', 25);
            $table->timestamps();

            $table->foreign('fk_payer')->references('id')->on('users');
        });

        Schema::create('websockets_statistics_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_id');
            $table->integer('peak_connection_count');
            $table->integer('websocket_message_count');
            $table->integer('api_message_count');
            $table->timestamps();
        });
    }

    public function down()
    {
        $tables = [
            'websockets_statistics_entries',
            'transactions',
            'permissoes_ver_pitch',
            'notifications',
            'finalidades_investimento',
            'rodadas_investidores',
            'rodadas_investimento',
            'mensagens',
            'formacao_membro_equipa',
            'experiencia_membro_equipa',
            'membrosequipa_cargosexecutivo_m_m',
            'membros_equipa_startup',
            'investidores_da_startup',
            'startups',
            'investidores',
            'instituicoes_experincia',
            'funcoes_experiencia',
            'setores_economico',
            'fases_desenvolvimento',
            'certificados_formacao',
            'cargos_executivo',
            'areas_formacao',
            'users',
        ];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
}
