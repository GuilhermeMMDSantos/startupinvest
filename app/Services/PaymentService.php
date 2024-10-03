<?php

namespace App\Services;

use Exception;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

use PaypalPayoutsSDK\Payouts\PayoutsPostRequest;
use PayPalHttp\HttpException;

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;


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
                "email_subject" => "Rodada " . $rodadaId . "na startupInveste, Bem Sucedida",
                "email_message" => "Recebeu o montante da Captação!",
            ],
            "items" => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => number_format($amount, 2, '.', ''),
                        "currency" => "USD",
                    ],
                    "note" => "Rodada " . $rodadaId . " na startupInveste, Bem Sucedida",
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

    private function getApiContext()
    {
        $apiContext = new ApiContext(new OAuthTokenCredential(config('services.paypal.client_id'), config('services.paypal.secret')));
        return $apiContext;
    }

    public function createPayment($amountValue)
    {
      
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item->setName('Startup')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($amountValue);

        $itemList = new ItemList();
        $itemList->setItems([$item]);
       
        $amount = new Amount();
        
        $amount->setCurrency('USD')
            ->setTotal($amountValue);
            
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Pagamento para App Laravel');
           
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.status')) // URL de retorno após pagamento
            ->setCancelUrl(route('paypal.status'));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);
        
        try{
            $payment->create($this->getApiContext());
            return ($payment->getApprovalLink());
        }catch(PayPalConnectionException $e)
        {
            throw new Exception($e);
        }
    }

    public function capturePayment($paymentId, $payerId)
    {
        $payment = Payment::get($paymentId, $this->getApiContext());
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try{
            $result = $payment->execute($execution, $this->getApiContext());
            if ($result->getState() == 'approved')
                return (1);
        }catch(PayPalConnectionException $e)
        {
            throw new Exception($e);
        }
    }
}
