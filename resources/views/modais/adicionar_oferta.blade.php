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
                            <label>Meta em Kwanzas</label>
                            <input type="text" class="form-control" name="meta" id="meta-oferta" style="background: #fdfdff;">
                            <span style="font-size:10px;color:red;" id="content-alert-unset-meta"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>Porcentagem em acções à oferecer</label>
                            <input type="text" class="form-control" name="porcentagem" id="porcentagem-oferta" style="background: #fdfdff;">
                            <span style="font-size:10px;color:red;" id="content-alert-unset-porcentagem"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6" style="padding-top:10px;">
                            <label>Conta Bancária</label>
                            <input type="text" class="form-control" disabled>
                            <span style="font-size:10px;color:red;" id="content-alert-unset-conta-bancaria"></span>
                        </div>
                        <div class="col-sm-6" style="padding-top:10px;">
                            <label>Término da Angariação</label>
                            <input type="date" class="form-control" name="termino" id="termino-oferta" style="background: #fdfdff;">
                            <span style="font-size:10px;color:red;" id="content-alert-unset-termino-angariacao"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12" style="padding-top:10px;">
                            <label>Pitch</label>
                            <input type="text" class="form-control" id="input-aux-pitch-video" placeholder="Nenhum video carregado" style="background: #fdfdff;" disabled>
                            <label class="btn btn-primary btn-lg btn-block"  for="input-pitch-video" role="button" style="height:30px;font-size:11px;border-radius:0px;">Carregar Video</label>
                            <input type="file" id="input-pitch-video" name="pitch_video" style="display:none;">
                            <span style="font-size:10px;color:red;" id="content-alert-unset-pitch-video"></span>
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