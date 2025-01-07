<div id="step-2" class="step">
    <h3>Vantagem Competitiva</h3>
    <div class="form-group">
        <label for="propriedade_intelectual">Você possui propriedade intelectual como vantagem
            competitiva?</label>
        <input type="text" class="form-control" id="propriedade_intelectual"
            name="propriedade_intelectual" value="{{ old('propriedade_intelectual') }}">
    </div>
    <div class="form-group">
        <label for="tecnologia_exclusiva">Você possui alguma tecnologia exclusiva como vantagem
            competitiva?</label>
        <input type="text" class="form-control" id="tecnologia_exclusiva"
            name="tecnologia_exclusiva" value="{{ old('tecnologia_exclusiva') }}">
    </div>
    <div class="form-group">
        <label for="acesso_canais_distribuicao">Você tem acesso exclusivo a canais de
            distribuição como vantagem competitiva?</label>
        <input type="text" class="form-control" id="acesso_canais_distribuicao"
            name="acesso_canais_distribuicao"
            value="{{ old('acesso_canais_distribuicao') }}">
    </div>
    <div class="form-group">
        <label for="grau_automacao">Qual o grau de automação em suas operações?</label>
        <input type="number" class="form-control" id="grau_automacao" name="grau_automacao"
            value="{{ old('grau_automacao') }}">
    </div>
    <button type="button" class="btn btn-secondary prev-step">Voltar</button>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>