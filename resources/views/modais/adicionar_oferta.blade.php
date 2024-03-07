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
                                <input type="text" class="form-control my-mask-money" name="meta" id="meta-oferta" style="background: #fdfdff;">
                            </div>
                            <span style="font-size:10px;color:red;margin-top:-4px;display:block;" id="content-alert-unset-meta"></span>

                        </div>
                        <div class="col-sm-6">
                            <label for="porcentagem-oferta">Acções à oferecer</label>

                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <label for="porcentagem-oferta" class="input-group-text">%</label>
                                </div>
                                <input type="text" class="form-control" name="porcentagem" id="porcentagem-oferta" style="background: #fdfdff;">
                            </div>
                            <span style="font-size:10px;color:red;margin-top:-4px;display:block;" id="content-alert-unset-porcentagem"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6" style="padding-top:10px;">
                            <label for="input-pitch-video">Pitch</label>
                            <input class="form-control" accept=".MP4,.MKV" type="file" id="input-pitch-video" name="pitch_video">
                            <span style="font-size:10px;color:red;" id="content-alert-unset-pitch-video"></span>
                        </div>

                        <div class="col-sm-6" style="padding-top:10px;">
                            <label for="termino-oferta">Término da Angariação</label>
                            <input type="date" class="form-control" name="termino" id="termino-oferta" style="background: #fdfdff;">
                            <span style="font-size:10px;color:red;" id="content-alert-unset-termino-angariacao"></span>
                        </div>
                    </div>



                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-publicar-oferta">Publicar</button>
            </div>
        </div>
    </div>
</div>