<div class="modal fade" id="modal-adicionar-membro-equipa" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Adionar Membro Equipa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-adionar-membro-equipa-body" style="font-size:14px;">
                <form enctype="multipart/form-data">

                    <div style="width:120px;height:120px;border:1px solid #ccc;border-radius:50%;margin:auto;">
                        <img src="{{asset('storage/armazenamento/startups/img/membros/img_standard_membro_equipa.png')}}" id="img-membro-equipa-add" accept=".jpg,.png" style="width:100%;height:100%;border-radius:50%;object-fit:contain !important;">
                    </div>

                    <div style="text-align:center;margin-bottom:35px; margin-top:7px;">
                    <input type="file" accept=".png,.jpg" name="img-membro-equipa-add" id="load_img-membro-equipa-add" hidden>
                        <label type="button" class="btn btn-primary" for="load_img-membro-equipa-add">
                            Carregar logotipo
                        </label>

                        <button type="button" id="btn-reset-imagem" class="btn btn-danger btn-remove-img-membro-equipa" style="margin-top:-7px;"><i class="fa fa-trash"></i></button>

                    </div>


                    <div class="row">
                        <div class=" col-12 col-sm-6 form-group group-nome-sobrenome">
                            <label>Nome</label>
                            <input type="text" name="nome" id="nome-membro-equipa" class="form-control" placeholder="ex.: Dário" autocomplete="off">
                            <span style="font-size:10px;color:red;" id="content-alert-unselected-nome-membro"></span>
                        </div>

                        <div class=" col-12 col-sm-6 form-group group-nome-sobrenome">
                            <label>Sobrenome</label>
                            <input type="text" name="sobrenome" id="sobrenome-membro-equipa" class="form-control" placeholder="ex.: Dário" autocomplete="off">
                            <span style="font-size:10px;color:red;" id="content-alert-unselected-sobrenome-membro"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="cargos-executivo">
                        </div>
                        <span style="font-size:10px;color:red;" id="content-alert-unselected-cargo-membro"></span>

                    </div>



                    <div class="form-group">
                        <label style="display: inline-block;background: #adb5bd54;width: 100%;padding: 5px;">Lista de Formações</label>
                        <ul id="lista-formacoes" style="list-style:none;padding-left:5px;padding-right:5px;">
                        </ul>
                        <div id="content-form-adicionar-formacao" style="border:1px solid #ccc;padding-top:8px; padding-left:7px; padding-right:7px;padding-bottom:10px; display:none;">

                            <div>
                                <label>Certificado</label>
                                <input type="text" id="formacao-certificado-input" class="form-control" placeholder="Licenciatura, Doutoramento..." autocomplete="off">
                                <input type="text" id="formacao-certificado-input-hide" hidden>
                                <span style="font-size:10px;color:red;" id="content-alert-unselected-certificado"></span>
                                <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-certificado">
                                </div>
                            </div>

                            <div>
                                <label>Área De Formação</label>
                                <input type="text" id="formacao-area-formacao-input" class="form-control" placeholder="Finança, Economia..." autocomplete="off">
                                <input type="text" id="formacao-area-formacao-input-hide" hidden>
                                <span style="font-size:10px;color:red;" id="content-alert-unselected-area-formacao"></span>
                                <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-area-formacao">
                                </div>
                            </div>

                            <div style="margin-top:5px;">
                                <button type="button" class="btn btn-primary btn-lg btn-block" id="btn-salvar-formacao" style="height:30px;font-size:11px;border-radius:0px;">Adicionar formação</button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block" id="btn-cancelar-add-formacao" style="height:30px;font-size:11px;border-radius:0px;">Cancelar</button>
                            </div>

                        </div>
                        <a role="button" style="color:blue;" id="btn-show-form-formacao">Adicionar formação</a>
                    </div>




                    <div class="form-group">
                        <label style="display: inline-block;background: #adb5bd54;width: 100%;padding: 5px;">Lista de Experiências</label>
                        <ul id="lista-experiencias" style="list-style:none;padding-left:5px;padding-right:5px;">
                        </ul>
                        <div id="content-form-adicionar-experiencia" style="border:1px solid #ccc; padding:8px 7px; padding-bottom:10px; display:none;">
                            <div>
                                <label>Função que exerce(u)</label>
                                <input type="text" id="experiencia-funcao-input" name="experiencia-funcao-input" class="form-control" placeholder="ex.: Gestor" autocomplete="off">
                                <input type="text" id="experiencia-funcao-input-hide" value="0" hidden>
                                <span style="font-size:10px;color:red;" id="content-alert-emptyfield-funcao-experiencia"></span>
                                <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-funcao-experiencia">
                                </div>
                            </div>

                            <div>
                                <label>Instituição</label>
                                <input type="text" id="experiencia-instituicao-input" name="experiencia-instituicao-input" class="form-control" placeholder="ex.: StartupInveste" autocomplete="off">
                                <input type="text" id="experiencia-instituicao-input-hide" value="0" hidden>
                                <span style="font-size:10px;color:red;" id="content-alert-emptyfield-instituicao-experiencia"></span>
                                <div style="position:relative;display:none;z-index:10;" id="lista-resultado-busca-instituicao-experiencia">
                                </div>
                            </div>

                            <div style="margin-top:5px;">
                                <button type="button" id="btn-salvar-experiencia" class="btn btn-primary btn-lg btn-block" style="height:30px;font-size:11px;border-radius:0px;">Adicionar experiência</button>
                                <button type="button" class="btn btn-secondary btn-lg btn-block" id="btn-cancelar-add-experiencia" style="height:30px;font-size:11px;border-radius:0px;">Cancelar</button>
                            </div>

                        </div>
                        <a role="button" id="btn-show-form-experiencia" style="color:blue;">Adicionar experiência</a>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-adicionar-membro-equipa">Salvar</button>
            </div>
        </div>
    </div>
</div>