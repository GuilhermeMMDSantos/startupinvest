<div id="step-1" class="step active">
    <h3>Informações do Mercado</h3>
    <div class="form-group">
        <label for="taxa_crescimento_mercado">Qual é a taxa de crescimento do mercado?</label>
        <input type="number" step="0.01" class="form-control" id="taxa_crescimento_mercado"
            name="taxa_crescimento_mercado" required>
    </div>
    <div class="form-group">
        <label for="participacao_mercado_concorrentes">Qual é a participação de mercado dos
            concorrentes?</label>
        <input type="number" step="0.01" class="form-control"
            id="participacao_mercado_concorrentes" name="participacao_mercado_concorrentes">
    </div>
    <div class="form-group">
        <label for="numero_concorrentes_diretos">Quantos concorrentes diretos existem?</label>
        <input type="number" class="form-control" id="numero_concorrentes_diretos"
            name="numero_concorrentes_diretos">
    </div>
    <div class="form-group">
        <label for="mercado_b2c">O mercado é B2C?</label>
        <select class="form-control" id="mercado_b2c" name="mercado_b2c">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>
    <div class="form-group">
        <label for="mercado_b2b">O mercado é B2B?</label>
        <select class="form-control" id="mercado_b2b" name="mercado_b2b">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>
    <div class="form-group">
        <label for="mercado_b2b2c">O mercado é B2B2C?</label>
        <select class="form-control" id="mercado_b2b2c" name="mercado_b2b2c">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
    </div>
    <div class="form-group">
        <label for="tamanho_mercado_alvo">Qual é o tamanho do mercado-alvo (em milhões)?</label>
        <input type="number" step="0.01" class="form-control" id="tamanho_mercado_alvo"
            name="tamanho_mercado_alvo">
    </div>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>