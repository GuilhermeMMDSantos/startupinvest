<div id="step-1" class="step">
    <h3>Informações do Mercado</h3>
    <div class="form-group">
        <label for="taxa_crescimento_mercado">Qual é a taxa de crescimento do mercado(%)?</label>
        <input type="number" step="0.01" class="form-control" id="taxa_crescimento_mercado"
            name="taxa_crescimento_mercado" required>
    </div>
    <div class="form-group">
        <label for="participacao_mercado_concorrentes">Qual é a participação de mercado dos
            concorrentes(%)?</label>
        <input type="number" step="0.01" class="form-control" id="participacao_mercado_concorrentes"
            name="participacao_mercado_concorrentes" required>
    </div>
    <div class="form-group">
        <label for="numero_concorrentes_diretos">Quantos concorrentes diretos existem?</label>
        <input type="number" class="form-control" id="numero_concorrentes_diretos" name="numero_concorrentes_diretos" required>
    </div>

    <div class="form-group">
        <label for="mercado_b2c">O Qual o modelo de negócio?</label>
        <select class="form-control" id="modelo_negocio" name="modelo_negocio" required>
            <option value="1">B2C</option>
            <option value="2">B2B</option>
            <option value="3">B2B2C</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tamanho_mercado_alvo">Qual é o tamanho do mercado-alvo (em milhões)?</label>
        <input type="number" step="0.01" class="form-control" id="tamanho_mercado_alvo" name="tamanho_mercado_alvo" required>
    </div>
    <div class="d-flex" style="flex-direction: row-reverse; margin-top:40px !important;">
        <button type="button" class="btn btn-primary next-step">Próximo</button>
    </div>
</div>
