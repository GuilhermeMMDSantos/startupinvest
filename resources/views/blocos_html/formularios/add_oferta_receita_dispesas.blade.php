<div id="step-4" class="step">
    <h3>Receita e Despesas</h3>
    <div class="form-group">
        <label for="ltv">Qual é o valor do tempo de vida do cliente (LTV)?</label>
        <input type="number" step="0.01" class="form-control" id="ltv" name="ltv">
    </div>
    <div class="form-group">
        <label for="ticket_medio">Qual é o ticket médio?</label>
        <input type="number" step="0.01" class="form-control" id="ticket_medio"
            name="ticket_medio">
    </div>
    <div class="form-group">
        <label for="cac">Qual é o custo de aquisição de cliente (CAC)?</label>
        <input type="number" step="0.01" class="form-control" id="cac" name="cac">
    </div>
    <div class="form-group">
        <label for="roi">Qual é o seu Retorno sobre o Investimento (ROI)?</label>
        <input type="number" class="form-control" id="roi" name="roi"
            value="{{ old('roi') }}">
    </div>
    <div class="form-group">
        <label for="tempo_medio_ciclo_vendas">Qual é o tempo médio do seu ciclo de
            vendas?</label>
        <input type="number" class="form-control" id="tempo_medio_ciclo_vendas"
            name="tempo_medio_ciclo_vendas" value="{{ old('tempo_medio_ciclo_vendas') }}">
    </div>
    <div class="form-group">
        <label for="taxa_crescimento_receita">Qual é a sua taxa de crescimento da
            receita?</label>
        <input type="number" class="form-control" id="taxa_crescimento_receita"
            name="taxa_crescimento_receita" value="{{ old('taxa_crescimento_receita') }}">
    </div>
    <div class="form-group">
        <label for="duracao_media_ciclo_vendas">Qual é a duração média do seu ciclo de
            vendas?</label>
        <input type="number" class="form-control" id="duracao_media_ciclo_vendas"
            name="duracao_media_ciclo_vendas" value="{{ old('duracao_media_ciclo_vendas') }}">
    </div>
    <div class="form-group">
        <label for="tempo_recebimento">Quanto tempo você demora para receber o pagamento após a
            venda?</label>
        <input type="number" class="form-control" id="tempo_recebimento"
            name="tempo_recebimento" value="{{ old('tempo_recebimento') }}">
    </div>
    <div class="form-group">
        <label for="receita_vendas">Qual é a sua receita proveniente das vendas?</label>
        <input type="number" class="form-control" id="receita_vendas" name="receita_vendas"
            value="{{ old('receita_vendas') }}">
    </div>
    <div class="form-group">
        <label for="receita_assinatura">Qual é a sua receita proveniente de
            assinaturas?</label>
        <input type="number" class="form-control" id="receita_assinatura"
            name="receita_assinatura" value="{{ old('receita_assinatura') }}">
    </div>
    <div class="form-group">
        <label for="receita_publicidade">Qual é a sua receita proveniente de
            publicidade?</label>
        <input type="number" class="form-control" id="receita_publicidade"
            name="receita_publicidade" value="{{ old('receita_publicidade') }}">
    </div>
    <div class="form-group">
        <label for="receita_outra">Quais são suas outras fontes de receita?</label>
        <input type="number" class="form-control" id="receita_outra" name="receita_outra"
            value="{{ old('receita_outra') }}">
    </div>
    <div class="form-group">
        <label for="qtd_fontes_receita">Quantas fontes de receita você possui?</label>
        <input type="number" class="form-control" id="qtd_fontes_receita"
            name="qtd_fontes_receita" value="{{ old('qtd_fontes_receita') }}">
    </div>
    <div class="form-group">
        <label for="margem_bruta">Qual é a sua margem bruta?</label>
        <input type="number" class="form-control" id="margem_bruta" name="margem_bruta"
            value="{{ old('margem_bruta') }}">
    </div>
    <div class="form-group">
        <label for="margem_liquida">Qual é a sua margem líquida?</label>
        <input type="number" class="form-control" id="margem_liquida" name="margem_liquida"
            value="{{ old('margem_liquida') }}">
    </div>
    <div class="form-group">
        <label for="despesas_operacionais_fixas">Quais são as suas despesas operacionais
            fixas?</label>
        <input type="number" class="form-control" id="despesas_operacionais_fixas"
            name="despesas_operacionais_fixas"
            value="{{ old('despesas_operacionais_fixas') }}">
    </div>
    <div class="form-group">
        <label for="despesas_operacionais_variaveis">Quais são as suas despesas operacionais
            variáveis?</label>
        <input type="number" class="form-control" id="despesas_operacionais_variaveis"
            name="despesas_operacionais_variaveis"
            value="{{ old('despesas_operacionais_variaveis') }}">
    </div>

    <button type="button" class="btn btn-secondary prev-step">Voltar</button>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>