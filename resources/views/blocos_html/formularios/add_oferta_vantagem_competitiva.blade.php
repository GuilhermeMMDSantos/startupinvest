<div id="step-5" class="step">
    <h3>Vantagem Competitiva</h3>
    
    <div class="form-group">
        <label>Factores exclusivos</label>
        <select class="form-control">
            <option value="1">Propriedade intelectual</option>
            <option value="2">Tecnologia exclusiva</option>
            <option value="3">Acesso exclusivo a canais de
                distribuição</option>
        </select>
    </div>

    <div class="form-group">
        <label for="grau_automacao">Qual o grau de automação nas operações (%)?</label>
        <input type="number" class="form-control" id="grau_automacao" name="grau_automacao"
            value="{{ old('grau_automacao') }}">
    </div>
    <button type="button" class="btn btn-secondary prev-step">Voltar</button>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>