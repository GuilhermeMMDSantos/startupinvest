<?php

namespace App\Own;

class ClassPagamento
{
    private $url;
    private $dataPost;
    private $token;

    private function callCurl($action)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        if ($action == 'token')
            curl_setopt($ch, CURLOPT_HEADER, false);
        else
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $this->token->access_token));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        curl_setopt($ch, CURLOPT_POST, true);

        if ($action != 'capture') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->dataPost);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($action == 'token')
            curl_setopt($ch, CURLOPT_USERPWD, env("PAYPAL_CLIENT_ID") . ':' . env("PAYPAL_CLIENT_SECRET"));

        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

    public function getToken()
    {
        $this->url = env("PAYPAL_URL_TOKEN");
        $this->dataPost = "grant_type=client_credentials";
        $this->token =  $this->callCurl('token');
    }

    /*  public function setInvoce($data)
    {
        $this->getToken();
        $this->url = env("PAYPAL_URL_PAYMENT");
        $this->dataPost = $data;

        return $this->callCurl('invoice');
    }*/

    public function setOrder($data)
    {
        $this->getToken();
        $this->url = "https://api-m.sandbox.paypal.com/v2/checkout/orders";
        $this->dataPost = json_encode($data);
        return $this->callCurl('order');
    }

    public function capturePayment($orderId)
    {
        $this->getToken();
        $this->url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/".$orderId."/capture";
        return $this->callCurl('capture');
    }
}
