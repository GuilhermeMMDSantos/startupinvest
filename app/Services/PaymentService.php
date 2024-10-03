<?php

namespace App\Services;

use Exception;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

use PaypalPayoutsSDK\Payouts\PayoutsPostRequest;
use PayPalHttp\HttpException;


class PaymentService
{

    private $client;

    public function __construct()
    {
        $environment = new SandboxEnvironment(config('services.paypal.client_id'), config('services.paypal.secret'));
        $this->client = new PayPalHttpClient($environment);
    }

    public function createPayout($recipientEmail, $amount, $rodadaId)
    {
        $request = new PayoutsPostRequest();
        $request->body = [
            "sender_batch_header" => [
                "sender_batch_id" => uniqid(),
                "email_subject" => "Rodada ".$rodadaId."na startupInveste, Bem Sucedida",
                "email_message" => "Recebeu o montante da Captação!",
            ],
            "items" => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => number_format($amount, 2, '.', ''),
                        "currency" => "USD",
                    ],
                    "note" => "Rodada ".$rodadaId." na startupInveste, Bem Sucedida",
                    "sender_item_id" => uniqid(),
                    "receiver" => $recipientEmail,
                ]
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return $response;
        } catch (HttpException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
