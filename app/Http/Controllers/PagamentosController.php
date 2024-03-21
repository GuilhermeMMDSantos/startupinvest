<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use App\RodadasInvestimento;
use App\User;
use Error;

class PagamentosController extends Controller
{

    public function index()
    {

        return view('Admin.pagamentos');
    }



    public function loadFormInvestirExpress(Request $request)
    {

        $idUser = User::where('code_user', $request->codigoStartup)
            ->first()->id;

        $rodada = RodadasInvestimento::where('fk_startup', $idUser)
            ->where('estado', 'aberta')
            ->first();

        $html = view('modais.forms.form_investir_express', compact('rodada'))->render();

        return response()->json([
            'html' => $html
        ]);
    }


    public function enviarOrdemTransferencia(Request $request)
    {
        $numeroTel = $request->numero_telefone;
        $valorMontante = $request->valor_a_investir;
        $status = 200;
        // Caso o status seja um número referente ao cliente(4XX)
        // Erro com o express (5xx)
        // Erro com metodo withHeader
        // Erro de processamento  - sucedido(200,result:sucess), nao tem saldo(200,empty), numero invalido(200,invalid)

        try {
           
            $getResponse = Http::withHeaders([
                'Accept' => 'application/pay.v1+json',
                'Content-Type' => 'application/json',
                'Autorization' => env('PAGAMENTO_ONLINE_ACCESS_KEY'),
                'Origin' => env('APP_URL')
            ])
                ->put('http://127.0.0.1:2024/transfer_order', [
                    'telephone' => $numeroTel,
                    'amount' => $valorMontante

                ]);
                return response()->json("resposta");

            if ($getResponse->status() != 200)
                throw new Error("Erro na requisição da API/ no servidor API");
            return response()->json(200, "teste");
        } catch (Exception $erro) {
            return response()->json(500,"Este");
        }
    }
}
