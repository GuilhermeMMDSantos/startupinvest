<?php

namespace App\Services;

use Exception;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaymentService
{

    private $client;

    public function __construct()
    {
        $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.secret'));
        $this->client = new PayPalHttpClient($environment);
    }

    public function createPayment($emailTo, $amount)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount
                    ],
                    'payee' => [
                        'email_address' => $emailTo
                    ]
                ]
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (Exception $e) {
            throw new Exception('Erro ao criar pedido.');
        }
    }

    public function capturePayment($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);
        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (Exception $e) {
            throw new Exception('Erro ao confirmar pagamento.');
        }
    }
}
