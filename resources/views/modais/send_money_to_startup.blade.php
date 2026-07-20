<div class="modal fade" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hiden="true" id="send-money-to-startup">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Envio Montante Captado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="padding-left:50px; padding-right:50px;">

                <div class="text-center mb-3">
                    <h5>Captado </h5>
                    <span id="valor-captado-form-send-money-to-startup">Valor Captado</span>
                </div>

                <div class="text-center mb-3">
                    <h5>Custo Captação(2,5%)</h5>
                    <span id="valor-custo-form-send-money-to-startup">Custo da Captação</span>
                </div>

                <div class="text-center mb-3">
                    <h4>Valor a Tranferir</h4>
                    <span id="valor-a-tranferir-form-send-money-to-startup" class="badge badge-warning p-2">Valor A Tranferir Para Startup</span>
                </div>

                <form id="form-send-money-to-startup">
                    <label>Comprovativo da Transferência</label>
                    <input type="number" name="identify" id="indentify" hidden>
                    <input class="form-control" accept=".pdf" type="file" name="comprovativo_transferencia">
                    <br>
                    <button class="btn btn-primary" id="submit-form-send-money-to-startup">Submeter</button>
                    <button class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                </form>

            </div>
        </div>
    </div>
</div>