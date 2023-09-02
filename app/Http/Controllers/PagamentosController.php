<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReferenciasPagamento;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;


class PagamentosController extends Controller
{
    public function createIdReference()
    {
        try {
            $idReference = Http::withHeaders([
                'autorization' => '93894af8880e140e80ebab7f839fc4aac6f5bdbc1ea8885787ef6c82f4174af7',
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
                    'autorization' => '93894af8880e140e80ebab7f839fc4aac6f5bdbc1ea8885787ef6c82f4174af7',
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

    public function storeReferenceLocaly($idReference, $idRodada, $idInvestidor, $valorMontante)
    {
        ReferenciasPagamento::create([
            'referencia' => $idReference,
            'fk_rodada_investimento' => $idRodada,
            'fk_investidor' => $idInvestidor,
            'valor_monetario' => $valorMontante,
        ]);
    }
}
