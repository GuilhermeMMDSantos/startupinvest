<div class="modal fade" id="modal-gerar-referencia-pagamento" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Gerar Referência</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form>
                    <div class="row">
                        <div class="col-12">
                            <label>Montante</label>
                            <input type="number" id="montante-da-referencia" class="form-control" placeholder="00,00">
                        <div style=" min-height:27px;">    
                            <small id="empty-label-alert-message" class="" style="color:red !important; display:none;">Informe o montante!</small>
                        </div>
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-confirmar-montante-referencia">Confirmar</button>
            </div>
        </div>
    </div>
</div>