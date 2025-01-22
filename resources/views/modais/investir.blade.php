<div class="modal fade" id="modal-investir" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Participar da Rodada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-left:50px; padding-right:50px;" id="modal-body-investir">
                <form id="investment-form">
                    @csrf
                    <div class="alert alert-info text-center" role="alert">
                        Será gerada uma referência bancária para tranferência bancária.
                    </div>
                    <div class="form-group">
                        <label for="remaining-amount" class="font-weight-bold">Valor restante para a meta da startup:</label>
                        <input type="text" class="form-control" id="remaining-amount" disabled>
                    </div>
                    <div class="form-group">
                        <label for="valor-a-investir" class="font-weight-bold">Quanto deseja investir (AOA)?</label>
                        <input type="text" class="form-control my-currency-format" name="valor_a_investir" id="valor-a-investir">
                    </div>

                    <div class="form-group">
                        <label for="remaining-amount" class="font-weight-bold">Participação societária a adquirir:</label>
                        <input type="text" class="form-control" id="porcentagem-por-valor" name="porcentagem_por_valor" value="0.0%" disabled>
                    </div>

                    <div>
                        <p>Investimento Coletivo. Investidor não pode investir todo valor que a startup busca.</p>
                        <p>Investidor não pode investir valor menor que o valor mínimo para a rodada.</p>
                        <p>O valor que o investidor deseja investir deve garantir que o restante necessário para atingir a meta da startup não seja inferior ao valor mínimo permitido na rodada, exceto se o restante for zero.</p>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-block">
                            <span class="spinner-border spinner-border-sm" id="btn-spinner-investir" role="status" aria-hidden="true"></span>
                            Gerar Referência de Pagamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>