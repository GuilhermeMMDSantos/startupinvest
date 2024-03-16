<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use App\ReferenciasPagamento;
use App\RodadasInvestidores;
use App\RodadasInvestimento;
use App\Events\ConfirmarPagamento;

class PagamentosController extends Controller
{

    public function index()
    {

        return view('Admin.pagamentos');
    }

    public function testeAPI()
    {

        try {
            $referencia = Http::withHeaders([
                'Accept' => 'application/pay.v1+json',
                'Content-Type' => 'application/json',
                'Autorization' => env('PAGAMENTO_ONLINE_ACCESS_KEY'),
                'Origin' => env('APP_URL')
            ])
                ->get('http://127.0.0.1:2024/teste', [
                    'nomeLegal' => "Startup-Investe.LTDA",
                    'dominio' => "http://localhost"

                ]);
            dd($referencia->body());
        } catch (Exception $erro) {
            dd($erro);
        }
    }


    /*  public function createIdReference()
    {
        try {
            $idReference = Http::withHeaders([
                'autorization' => env('PROXYPAY_ACCESS_KEY'),
                'Accept' => 'application/vnd.proxypay.v2+json'
            ])
                ->post('http://127.0.0.1:3030/reference_ids')['id'];

            return  $idReference;
        } catch (Exception $e) {
            return null;
        }
    }

    public function createReference(Request $request)
    {

        $idStartup = $request->user;
        $idRodada = $request->rodada;
        $valorMontante = $request->montante;
        $idInvestidor = Auth::user()->id;
        $endDate = Carbon::now()->addDay(2)->format('Y-m-d');
        $map = array(
            "id" => "bar",
            "name" => "foo",
            "mobile" => "942488359",
            "email" => "guiframart@hotmail.com"
        );
        $idReference = $this->createIdReference();


        $statusCode = 500;


        if ($idReference != null) {
            try {
                $referencia = Http::withHeaders([
                    'autorization' => env('PROXYPAY_ACCESS_KEY'),
                    'Accept' => 'application/vnd.proxypay.v2+json',
                    'Content-Type' => 'application/json'
                ])
                    ->put('http://127.0.0.1:3030/references/' . $idReference, [
                        'amount' => $valorMontante,
                        'end_datetime' => $endDate,
                        'custom_fields' => $map

                    ]);

                return response()->json(["response" => $referencia]);

                $statusCode = 200;
            } catch (Exception $e) {
                $statusCode = 500;
            }
        }

        $this->storeReferenceLocaly($idReference, $idRodada, $idInvestidor, $valorMontante);


        $htmlEncapsulation = '<p style="font-size:20px; font-weight:bold; background:#febd69;color:white; height:100%;padding-top:10px; padding-bottom:10px;">Ref. ' . $idReference . '</p>';

        return response()->json([
            'html' => $htmlEncapsulation,
            'status' => $statusCode
        ]);
    }

 

    public function confirmPayment(Request $req)
    {

        $paymentId = $req->paymentId;

        $response = Http::withHeaders([
            'autorization' => env('PROXYPAY_ACCESS_KEY'),
            'Accept' => 'application/vnd.proxypay.v2+json'
        ])
            ->delete('http://127.0.0.1:3030/payments/' . $paymentId);

        if ($response->status() != 200)
            return response()->json(['status' => 500], 500);

        ReferenciasPagamento::where('paymentId', $paymentId)
            ->update([
                'status' => 'pago'
            ]);

        $referencia = ReferenciasPagamento::where('paymentId', $paymentId)->first();

        RodadasInvestidores::create([
            'fk_rodada' => $referencia->fk_rodada_investimento,
            'fk_investidor' => $referencia->fk_investidor,
            'valor_investido' => $referencia->valor_investido
        ]);

        $rodadaInvestimento =  RodadasInvestimento::where('id', $referencia->fk_rodada_investimento)->first();

        $novoValorObtido = $rodadaInvestimento->valor_obtido + $referencia->valor_investido;

        $atributosAtualizar = [];
        $atributosAtualizar['valor_obtido'] = $novoValorObtido;

        if ($novoValorObtido >= $rodadaInvestimento->valor_objetivo)
            $atributosAtualizar['estado'] = 'fechada';

        RodadasInvestimento::where('id', $referencia->fk_rodada_investimento)
            ->update($atributosAtualizar);

        event(new ConfirmarPagamento());
        
        return response()->json(['status' => 200], 200);
    }*/
}
