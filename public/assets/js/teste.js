// Create the Card Fields Component and define callbacks
const cardField = paypal.CardFields({
  createOrder: function (data) {
      setProcessing(true);
      
      var postData = {request_type: 'create_order', payment_source: data.paymentSource};
      return fetch("/api/TESTE/orders", {
          method: "POST",
          headers: {'Accept': 'application/json'},
          body: encodeFormData(postData)
      })
      .then((res) => {
          return res.json();
      })
      .then((result) => {
          setProcessing(false);
          if(result.status == 1){
              return result.data.id;
          }else{
              resultMessage(result.msg);
              return false;
          }
      });
  },
  onApprove: function (data) {
      setProcessing(true);

      const { orderID } = data;
      var postData = {request_type: 'capture_order', order_id: orderID};
      return fetch('/api/TESTE/capture', {
          method: "POST",
          headers: {'Accept': 'application/json'},
          body: encodeFormData(postData)
      })
      .then((res) => {
          return res.json();
      })
      .then((result) => {
          // Redirect to success page
          if(result.status == 1){
             // window.location.href = "payment-status.php?checkout_ref_id="+result.ref_id;
             console.log("SECESSO");
             console.log(result.data);
          }else{
              resultMessage(result.msg);
          }
          setProcessing(false);
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
      cardField.submit().then(() => {
          // submit successful
          console.log("Sucesso na submissão do formulário");
      })
      .catch((error) => {
          resultMessage(`Sorry, your transaction could not be processed... >>> ${error}`);
      });
  });
} else {
  // Hides card fields if the merchant isn't eligible
  console.log("card fields the merchant isn't eligible");
  document.querySelector("#checkout-form").style = "display: none";
}

const encodeFormData = (data) => {
  var form_data = new FormData();

  for ( var key in data ) {
      form_data.append(key, data[key]);
  }
  return form_data;   
}

// Show a loader on payment form processing
const setProcessing = (isProcessing) => {
  if (isProcessing) {
      document.querySelector(".overlay").classList.remove("hidden");
  } else {
      document.querySelector(".overlay").classList.add("hidden");
  }
}

// Display status message
const resultMessage = (msg_txt) => {
  const messageContainer = document.querySelector("#paymentResponse");

  messageContainer.classList.remove("hidden");
  messageContainer.textContent = msg_txt;
  
  setTimeout(function () {
      messageContainer.classList.add("hidden");
      messageContainer.textContent = "";
  }, 5000);
}