<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;
use Illuminate\Validation\ValidationException;

class PaymentService
{

    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:3000',]);
    }

    public function createRefPayment($data)
    {
        try {
            $response = $this->client->post('/reference_ids');
            $idRef = json_decode($response->getBody()->getContents(), true);
            $response = $this->client->put("/references/{$idRef}", [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer 1234567'
                ]
            ]);
            $status = $response->getStatusCode();
            if ($status != 204)
                throw new Exception("Requisição para criar referência, não sucedida.");
            return $idRef;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function checkInvestmentRules($rodada, $amount, $porcentage)
    {
        $messages = [];
        $haveMessage = false;

        if ($porcentage <= 0) {
            $haveMessage = true;
            $messages['porcentagem'] = 'Valor de porcentagem não pode ser menor que 0.';
        }
        if ($amount < $rodada->valor_minimo_investimento) {
            $haveMessage = true;
            $messages['montante.2'] = 'Investidor não pode investir valor menor que o valor mínimo para a rodada.).';
        }
        if ($amount == $rodada->valor_objetivo) {
            $haveMessage = true;
            $messages['montante.3'] = 'Investidor não pode investir todo valor que a startup busca.';
        }
        if ($rodada->valor_objetivo - ($rodada->valor_obtido + $amount) < $rodada->valor_minimo_investimento && ($rodada->valor_objetivo - ($rodada->valor_obtido + $amount) != 0)) {
            $haveMessage = true;
            $messages['montante.4'] = 'O valor que o investidor deseja investir deve garantir que o restante necessário para atingir a meta da startup não seja inferior ao valor mínimo permitido na rodada, exceto se o restante for zero.';
        }
        if ($haveMessage)
            throw ValidationException::withMessages($messages);
    }

    public function porcentageCalculo($montante, $valorObjetivo, $accoes)
    {
        $x = 100 * $montante / $valorObjetivo;
        $y = (($x * $accoes) / 100) . '';

        return $y;
    }
}
