<div id="step-2" class="step">
    <h3>Histórico de Investimento</h3>
    <div class="form-group">
        <label for="rodadas_investimento">Quantas rodadas de investimento você já
            participou?</label>
        <input type="number" class="form-control" id="rodadas_investimento"
            name="rodadas_investimento" value="{{ old('rodadas_investimento') }}">
    </div>
    <div class="form-group">
        <label for="maior_valor_captado">Qual foi o maior valor captado até agora?</label>
        <input type="number" class="form-control" id="maior_valor_captado"
            name="maior_valor_captado" value="{{ old('maior_valor_captado') }}">
    </div>
    <div class="form-group">
        <label for="participou_incubacao">Você participou de algum programa de
            incubação?</label>
        <select class="form-control" id="participou_incubacao" name="participou_incubacao">
            <option value="sim"
                {{ old('participou_incubacao') == 'sim' ? 'selected' : '' }}>Sim</option>
            <option value="não"
                {{ old('participou_incubacao') == 'não' ? 'selected' : '' }}>Não</option>
        </select>
    </div>
    <button type="button" class="btn btn-secondary prev-step">Voltar</button>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>