// Create the Card Fields Component and define callbacks
const cardField = paypal.CardFields({
    createOrder: function (data) {

        let montante = $("#valor-a-investir").val();
        let codigoStartup = $("#codigo-startup").val();
        let payer = $("#reference_payer").val();
        var postData = { montante: montante, codigoStartup: codigoStartup, payer: payer };
        return fetch("/api/TESTE/orders", {
            method: "POST",
            headers: { 'Accept': 'application/json' },
            body: encodeFormData(postData)
        })
            .then((res) => {
                return res.json();
            })
            .then((result) => {
                if (result.status == 1) {
                    return result.data.id;
                }
                else if (result.status == 0) {
                    throw result.message;
                }
                else {
                    console.log(result.msg);
                    return false;
                }
            });
    },
    onApprove: function (data) {
        const { orderID } = data;
        var porcentagemPeloMontante = $("#porcentagem-por-valor").val();
        var postData = { order_id: orderID, codigoStartup: codigoStartup, porcentagemPeloMontante: porcentagemPeloMontante };
        return fetch('/api/TESTE/capture', {
            method: "POST",
            headers: { 'Accept': 'application/json' },
            body: encodeFormData(postData)
        })
            .then((res) => {
                return res.json();
            })
            .then((result) => {
                if (result.status == 1) {
                    console.log("SECESSO");
                    showPopUpAlertForPay('container-popup-alert-perfil-startup', 'TRANSAÇÃO EFECTUADA COM SUCESSO.', 'sucesso');
                } else {
                    console.log(result.msg);
                }

            });
    },
    onError: function (error) {
        // Do something with the error from the SDK
        console.log("error from the SDK");
    },
});

// Render each field after checking for eligibility
if (cardField.isEligible()) {
    const nameField = cardField.NameField();
    nameField.render("#card-name-field-container");

    const numberField = cardField.NumberField();
    numberField.render("#card-number-field-container");

    const cvvField = cardField.CVVField();
    cvvField.render("#card-cvv-field-container");

    const expiryField = cardField.ExpiryField();
    expiryField.render("#card-expiry-field-container");

    // Add click listener to submit button and call the submit function on the CardField component
    document
        .getElementById("card-field-submit-button")
        .addEventListener("click", () => {

            $("#btn-spinner-investir").css({
                'display': 'inline-block'
            });

            cardField.submit().then(() => {

                console.log("Sucesso na submissão do formulário");
            })
                .catch((error) => {
                    console.log(`Sorry, your transaction could not be processed... >>> ${error}`);
                    if (error == "Error: INVALID_NUMBER")
                        error = "Número do Cartão Inválido.";
                    else if (error == "Error: INVALID_CVV")
                        error = "Número de Confirmação do Cartão Inválido.";
                    else if (error == "Error: INVALID_EXPIRY")
                        error = "Data de Expiração Inválida.";
                    else
                        error = "Cartão Inválido.";
                    showPopUpAlertForPay('container-popup-alert-modal-investir', error, 'error');
                    $("#btn-spinner-investir").css({
                        'display': 'none'
                    });

                });
        });
} else {
    // Hides card fields if the merchant isn't eligible
    console.log("card fields the merchant isn't eligible");
    document.querySelector("#checkout-form").style = "display: none";
}

const encodeFormData = (data) => {
    var form_data = new FormData();

    for (var key in data) {
        form_data.append(key, data[key]);
    }
    return form_data;
}

function showPopUpAlertForPay(container_popup, mensagem, tipo) {

    var color = '#e68790';

    if (tipo == 'sucesso')
        color = '#5fa56f';

    var componente = "<div class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay=4500 data-animation=true style='z-index:10;background:" + color + ";'>\
    <div class='toast-header'>\
        <i class='fa fa-bell rounded mr-2'></i>\
        <strong class='mr-auto'>Validação</strong>\
    </div>\
    <div class='toast-body'>\
        " + mensagem + "\
    </div>\
</div>";

    $("#" + container_popup).empty();

    $("#" + container_popup).append(componente);

    $("#" + container_popup + " .toast").toast('show');

}

