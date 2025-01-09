<div id="step-7" class="step">
    <h3>Histórico de Investimento</h3>
    <div class="form-group">
        <label for="rodadas_investimento">Quantas rodadas de investimento a startup
            participou?</label>
        <input type="number" class="form-control" id="rodadas_investimento" name="rodadas_investimento" value="">
    </div>
    <div class="form-group">
        <label for="maior_valor_captado">Qual o maior valor captado até agora?</label>
        <input type="number" class="form-control" id="maior_valor_captado" name="maior_valor_captado">
    </div>
    <div class="form-group">
        <label for="participou_incubacao">Participou de algum programa de
            incubação ou aceleração?</label>
        <div style="display:flex; gap:10px; margin-top:8px; flex-wrap:wrap;">
            <div>
                <input type="radio" name="participacao_aceleradora" id="form-oferta-participacao_aceleradora-sim" value="1">
                <label for="form-oferta-participacao_aceleradora-sim">Sim</label>
            </div>
            <div>
                <input type="radio" name="participacao_aceleradora" id="form-oferta-participacao_aceleradora-nao" value="0">
                <label for="form-oferta-participacao_aceleradora-nao">Não</label>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-secondary prev-step">Voltar</button>
    <button type="button" class="btn btn-primary next-step">Próximo</button>
</div>
