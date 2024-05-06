<div class="modal fade" id="modal-investir" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div id="container-popup-alert-modal-investir" style="position:absolute;right:10px;top:10px;z-index:40;">

    </div>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size:14px;">Participar da Rodada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding-left:50px;padding-right:50px;" id="modal-body-investir">

                <div id="forms-meio-pagamento-investir">

                    <input type="text" value="{{$code}}" id="reference_payer" hidden>
                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label for="valor-a-investir" style="font-size:12px;">Montante a Investir (AOA)</label>
                            <input type="text" class="form-control my-currency-format" name="valor_a_investir" id="valor-a-investir" style="height:55px !important;border-radius:5px;">
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="porcentagem-por-valor" style="font-size:12px;">Porcentagem pelo montante</label>
                            <input type="text" class="form-control" name="porcentagem_por_valor" id="porcentagem-por-valor" value="0" style="height:55px !important;border-radius:5px;" disabled>
                        </div>
                    </div>

                    <div class="d-flex">
                        <input type="radio" style="display: block; width: 23px;" checked>
                        <div style="height: 50px;">
                            <img class="h-100 w-100" src="{{asset('assets/img/bandeiras.png')}}">
                        </div>
                    </div>

                    <div>
                        <div id="checkout-form">
                            <div id="card-name-field-container" style="display:none;"></div>

                            <div id="card-number-field-container"></div>
                            <div class="row">
                                <div class="col-12 col-sm-6" id="card-expiry-field-container"></div>
                                <div class="col-12 col-sm-6" id="card-cvv-field-container"></div>
                            </div>
                            <br>
                            <div>
                                <button id="card-field-submit-button" type="button">
                                    <span class="spinner-border spinner-border-sm" id="btn-spinner-investir" role="status" aria-hidden="true"></span>
                                    Investir
                                </button>
                                &nbsp;&nbsp;
                                <button type="button" data-dismiss="modal" aria-label="Close">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>