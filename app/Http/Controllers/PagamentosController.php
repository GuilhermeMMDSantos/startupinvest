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
                'x-api-key' => 'PMAK-645fc7cf7042182af5051b75-b7a3f39e8ea2dac5bfb2b49e9364171193',
                'Accept' => 'application/vnd.proxypay.v2+json'
            ])
                ->post('https://426846f5-cae0-4cd3-8bdb-41052424dc76.mock.pstmn.io/reference_ids')['id'];

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

        $statusCode = 200;



        if ($idReference != null) {
            try {
                $referencia = Http::withHeaders([
                    'x-api-key' => 'PMAK-645fc7cf7042182af5051b75-b7a3f39e8ea2dac5bfb2b49e9364171193',
                    'Accept' => 'application/vnd.proxypay.v2+json',
                    'Content-Type' => 'application/json'
                ])
                    ->put('https://426846f5-cae0-4cd3-8bdb-41052424dc76.mock.pstmn.io/references/' . $idReference, [
                        'amount' => $valorMontante,
                        'end_datetime' => $endDate,
                        'custom_fields' => $map

                    ]);
            } catch (Exception $e) {
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
