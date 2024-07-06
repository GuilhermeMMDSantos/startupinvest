<div class="modal fade" id="modal-adicionar-oferta" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">


    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Criar Oferta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form enctype="multipart/form-data" id="form-criar-oferta">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="meta-oferta">Meta à captar</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="meta-oferta">Kz</label>
                                </div>
                                <input type="text" class="form-control my-currency-format mt-0" name="meta" id="meta-oferta" style="background: #fdfdff;">
                            </div>
                            <span style="margin-top:-5px;font-size: .875em;color: #dc3545;display:block;" id="alert-meta" class="alert-adicionar-oferta"></span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label for="porcentagem-oferta">Acções à oferecer</label>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label for="porcentagem-oferta" class="input-group-text">%</label>
                                </div>
                                <input type="text" class="form-control my-currency-format mt-0" name="porcentagem" id="porcentagem-oferta" style="background: #fdfdff;">
                            </div>
                            <span style="margin-top:-5px;font-size: .875em;color: #dc3545;display:block;" id="alert-porcentagem" class="alert-adicionar-oferta"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6" style="padding-top:10px;">
                            <label for="montante-acrescer">+Taxa de Captação</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="montante-acrescer">Kz</label>
                                </div>
                                <input type="text" class="form-control  mt-0" name="montante_acrescer" id="montante-acrescer" style="background: #fdfdff;" value="0,00"  readonly>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6" style="padding-top:10px;">
                            <label for="max-investidores">Número máximo de investidores</label>
                            <input type="number" class="form-control" name="max_investidores" id="max-investidores" style="background: #fdfdff;" min='1' value="1">
                            <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;" id="alert-n-investidor" class="alert-adicionar-oferta"></span>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12 col-sm-6" style="padding-top:10px;">
                            <label for="input-pitch-video">Pitch (Video - <span id="pitch-label-tamanho">max.64MB</span>)</label>
                            <input class="form-control" accept=".MP4,.MKV" type="file" id="input-pitch-video" name="pitch_video">
                            <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;" id="alert-pitch" class="alert-adicionar-oferta"></span>
                        </div>

                        <div class="col-12 col-sm-6" style="padding-top:10px;">
                            <label for="termino-oferta">Término da Angariação</label>
                            <input type="date" class="form-control" name="termino" id="termino-oferta" style="background: #fdfdff;">
                            <span style="margin-top:1px;font-size: .875em;color: #dc3545;display:block;" id="alert-data-angariacao" class="alert-adicionar-oferta"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-publicar-oferta">
                    <span class="spinner-border spinner-border-sm" id="btn-spinner-oferta" role="status" aria-hidden="true"></span>
                    <span>Publicar</span>
                </button>
            </div>
        </div>
    </div>
</div>