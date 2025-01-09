<div id="step-4" class="step">
    <h3>Receita e Despesas</h3>
    <div class="form-group">
        <label for="ltv">Qual é o valor do tempo de vida do cliente (LTV; KZ)?
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Valor médio que cada cliente gera em receita durante sua relação com a empresa."></i></label>
        </label>
        <input type="number" step="0.01" class="form-control" id="ltv" name="ltv">
    </div>
    <div class="form-group">
        <label for="ticket_medio">Qual o Ticket médio mansal(Kz)?
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Média de receita gerada por venda."></i></label>
        <input type="number" step="0.01" class="form-control" id="ticket_medio"
            name="ticket_medio">
    </div>
    <div class="form-group">
        <label for="cac">Qual é o custo de aquisição de cliente (CAC; Kz)?</label>
        <input type="number" step="0.01" class="form-control" id="cac" name="cac">
    </div>
    <div class="form-group">
        <label for="roi">Qual é o seu Retorno sobre o Investimento (ROI; %)?
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Facto/previsão percentual de retorno obtido em relação ao valor investido."></i>
        </label>
        <input type="number" class="form-control" id="roi" name="roi"
           >
    </div>
    <div class="form-group">
        <label for="tempo_medio_ciclo_vendas">Qual é o tempo médio do seu ciclo de
            vendas (dias)?
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Tempo, em média, a empresa leva para converter um lead (potencial cliente) em um cliente pagante."></i>
        </label>
        <input type="number" class="form-control" id="tempo_medio_ciclo_vendas"
            name="tempo_medio_ciclo_vendas" >
    </div>
    <div class="form-group">
        <label for="taxa_crescimento_receita">Qual é a taxa de crescimento da
            receita(%)?</label>
        <input type="number" class="form-control" id="taxa_crescimento_receita"
            name="taxa_crescimento_receita">
    </div>
    <div class="form-group">
        <label for="tempo_recebimento">Quanto tempo demora para receber o pagamento após a
            venda(dias)?</label>
        <input type="number" class="form-control" id="tempo_recebimento"
            name="tempo_recebimento" >
    </div>
    <div class="form-group">
        <label for="possiveis_fontes_de_receita">Qual a fonte de receita</label>
        <select class="form-control">
            <option value="1">Produto</option>
            <option value="2">Assinatura</option>
            <option value="3">Publicidade</option>
            <option value="4">Outra</option>
        </select>
    </div>
    <div class="form-group">
        <label for="qtd_fontes_receita">Quantas fontes de receita você possui?</label>
        <input type="number" class="form-control" id="qtd_fontes_receita"
            name="qtd_fontes_receita">
    </div>
    <div class="form-group">
        <label for="margem_bruta">Qual é a sua margem bruta(%)?</label>
        <input type="number" class="form-control" id="margem_bruta" name="margem_bruta"
            >
    </div>
    <div class="form-group">
        <label for="margem_liquida">Qual é a sua margem líquida(%)?</label>
        <input type="number" class="form-control" id="margem_liquida" name="margem_liquida"
            >
    </div>
    <div class="form-group">
        <label for="despesas_operacionais_fixas">Quais são as suas despesas operacionais
            fixas(Kz)?</label>
        <input type="number" class="form-control" id="despesas_operacionais_fixas"
            name="despesas_operacionais_fixas">
    </div>
    <div class="form-group">
        <label for="despesas_operacionais_variaveis">Quais são as suas despesas operacionais
            variáveis(Kz)?</label>
        <input type="number" class="form-control" id="despesas_operacionais_variaveis"
            name="despesas_operacionais_variaveis"
           >
    </div>

    <button type="button" class="btn btn-secondary prev-step">Voltar</button>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>