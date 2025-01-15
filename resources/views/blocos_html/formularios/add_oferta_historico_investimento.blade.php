<div id="step-7" class="step">
    <h3>Histórico de Investimento</h3>
    <div class="form-group">
        <label for="rodadas_investimento">Quantas rodadas de investimento a startup
            participou?</label>
        <input type="number" class="form-control" id="rodadas_investimento" name="rodadas_investimento" required>
    </div>
    <div class="form-group">
        <label for="maior_valor_captado">Qual o maior valor captado até agora?</label>
        <input type="number" class="form-control" id="maior_valor_captado" name="maior_valor_captado" required>
    </div>
    <div class="form-group">
        <label for="participou_incubacao">Participou de algum programa de
            incubação ou aceleração?</label>
        <div>
            <div>
                <input type="radio" name="participacao_aceleradora" id="form-oferta-participacao_aceleradora-sim"
                    value="1">
                <label for="form-oferta-participacao_aceleradora-sim">Sim</label>
            </div>
            <div>
                <input type="radio" name="participacao_aceleradora" id="form-oferta-participacao_aceleradora-nao"
                    value="0" checked>
                <label for="form-oferta-participacao_aceleradora-nao">Não</label>
            </div>
        </div>
    </div>
    <div class="d-flex" style="justify-content: flex-end; gap:10px;margin-top:40px !important;">
        <button type="button" class="btn btn-secondary prev-step">Voltar</button>
        <button type="button" class="btn btn-primary next-step">Próximo</button>
    </div>
</div>
