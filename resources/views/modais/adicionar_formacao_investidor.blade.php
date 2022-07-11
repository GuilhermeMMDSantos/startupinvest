<div class="modal fade" id="modal-adicionar-formacao-investidor" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Adionar Formação Investidor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size:14px;">
                <form id="form-cadastrar-formacao">
                    @csrf
                    <div id="content-form-adicionar-formacao" style="border:1px solid #ccc;padding-top:8px; padding-left:7px; padding-right:7px;padding-bottom:10px;  ">

                        <div>
                            <label>Certificado</label>
                            <input type="text" name="formacao_certificado_input" id="formacao-certificado-input" class="form-control" autocomplete="off">
                            <input type="text" name="id_formacao_certificado" id="formacao-certificado-input-hide" hidden>
                            <span style="font-size:10px;color:red;" id="content-alert-unselected-certificado"></span>
                            <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-certificado">
                            </div>
                        </div>

                        <div>
                            <label>Área De Formação</label>
                            <input type="text" name="formacao_area_formacao_input" id="formacao-area-formacao-input" class="form-control" autocomplete="off">
                            <input type="text" name="id_formacao_area_formacao" id="formacao-area-formacao-input-hide" hidden>
                            <span style="font-size:10px;color:red;" id="content-alert-unselected-area-formacao"></span>
                            <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-area-formacao">
                            </div>
                        </div>

                        <div>
                            <label>Data inico</label>
                            <input type="Month" name="formacao_mes_ano_inicio" id="formacao-mes-ano-inicio" class="form-control">
                            <span style="font-size:10px;color:red;" id="content-alert-unselected-data-formacao-inicio"></span>
                        </div>

                        <div>
                            <label>Data Fim/Prevista</label>
                            <input type="Month" name="formacao_mes_ano_fim" id="formacao-mes-ano-fim" class="form-control">
                            <span style="font-size:10px;color:red;" id="content-alert-unselected-data-formacao-fim"></span>
                        </div>

                        <div style="margin-top:5px;">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" id="btn-salvar-formacao" style="height:30px;font-size:11px;border-radius:0px;">Adicionar formação</button>
                            <button type="reset" data-dismiss="modal" class="btn btn-secondary btn-lg btn-block" id="btn-cancelar-add-formacao" style="height:30px;font-size:11px;border-radius:0px;">Cancelar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>