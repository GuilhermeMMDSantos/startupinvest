<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- To be replaced with your own stylesheet -->
    <link rel="stylesheet" type="text/css" href="https://www.paypalobjects.com/webstatic/en_US/developer/docs/css/cardfields.css" />
    <!-- Express fills in the clientId variable -->
    <script src="https://www.paypal.com/sdk/js?components=card-fields&client-id=AZyNcOI3rX2NQ92uaU7RpNBW0f0N9SvQM_4FjtpkUaNij05CTlVLN1dj6E1J1mteOqUJXNtRtPE5y7QJ"></script>
</head>

<body>

    <div class="overlay hidden">
        <div class="overlay-content"><img src="{{asset('assets/gifs/gif1.gif')}}" alt="Processing..." /></div>
    </div>

    <div>
        <!-- Display status message -->
        <div id="paymentResponse" class="hidden"></div>

        <div id="checkout-form">
            <!-- Containers for Card Fields hosted by PayPal -->
            <div id="card-name-field-container"></div>
            <div id="card-number-field-container"></div>
            <div id="card-expiry-field-container"></div>
            <div id="card-cvv-field-container"></div>

            <br><br>
            <button id="card-field-submit-button" type="button">
                Pay now with Card Fields
            </button>
        </div>
    </div>
    <script src="{{asset('assets/js/teste.js')}}"></script>
</body>

</html>