<div class="modal fade" id="modal-adicionar-experiencia-investidor" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Adionar Experiência Investidor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"   style="font-size:14px;">
                <form  id="form-cadastrar-experiencia">
                    @csrf
                    <div id="content-form-adicionar-experiencia" style="border:1px solid #ccc; padding:8px 7px; padding-bottom:10px;">
                        <div>
                            <label>Função que exerce(u)</label>
                            <input type="text" id="experiencia-funcao-input" name="experiencia_funcao_input" class="form-control" placeholder="Informe o Outro" autocomplete="off">
                            <input type="text" name="id_experiencia_funcao" id="experiencia-funcao-input-hide" value="0" hidden>
                            <span style="font-size:10px;color:red;" id="content-alert-emptyfield-funcao-experiencia"></span>
                            <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-funcao-experiencia">
                            </div>
                        </div>

                        <div>
                            <label>Instituição</label>
                            <input type="text" id="experiencia-instituicao-input" name="experiencia_instituicao_input" class="form-control" placeholder="Informe o Outro" autocomplete="off">
                            <input type="text" name="id_experiencia_instituicao" id="experiencia-instituicao-input-hide" value="0" hidden>
                            <span style="font-size:10px;color:red;" id="content-alert-emptyfield-instituicao-experiencia"></span>
                            <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-instituicao-experiencia">
                            </div>
                        </div>

                        <div>
                            <label>Data inico</label>
                            <input type="Month" name="experiencia_mes_ano_inicio" id="experiencia-mes-ano-inicio" class="form-control" autocomplete="off">
                            <span style="font-size:10px;color:red;" id="content-alert-emptyfield-datainico-experiencia"></span>
                        </div>

                        <div>
                            <label>Data fim</label>
                            <input type="Month" name="experiencia_mes_ano_fim" id="experiencia-mes-ano-fim" class="form-control" autocomplete="off">
                        </div>

                        <div style="margin-top:5px;">
                            <button type="submit" id="btn-salvar-experiencia" class="btn btn-primary btn-lg btn-block" style="height:30px;font-size:11px;border-radius:0px;">Adicionar experiência</button>
                            <button type="reset"  data-dismiss="modal" class="btn btn-secondary btn-lg btn-block" id="btn-cancelar-add-experiencia" style="height:30px;font-size:11px;border-radius:0px;">Cancelar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>