<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\RodadasInvestimento;
use App\User;
use App\Own\ClassPagamento;
use App\Transactions;
use ErrorException;
use App\Own\ClassRodadas;
use App\RodadasInvestidores;
use App\Events\AtualizarEstadoRodada;
use App\Startups;

class PagamentosController extends Controller
{

  public function index()
  {

    return view('Admin.pagamentos');
  }




  public function loadFormInvestirPaypal(Request $request)
  {
    $idUser = User::where('code_user', $request->codigoStartup)
      ->first()->id;

    $rodada = RodadasInvestimento::where('fk_startup', $idUser)
      ->where('estado', 'aberta')
      ->first();

    $html = view('modais.forms.form_investir_paypal', compact('rodada'))->render();

    return response()->json([
      'html' => $html
    ]);
  }


  public function teste()
  {
    return view('teste');
  }

  public function orders(Request $request)
  {
    $user = User::where('code_user', $request->codigoStartup)
      ->first();
    $itemNumber = $request->codigoStartup;
    $itemName = $user->startup->nome;
    $montante = str_replace(',', '.', str_replace('.', '', $request->montante))+0.0;
    $idPayer = $request->payer;
    $currency = "USD";

    $postParams = array(
      "intent" => "CAPTURE",
      "purchase_units" => array(
        array(
          "custom_id" => $itemNumber,
          "description" => $itemName,
          "amount" => array(
            "currency_code" => $currency,
            "value" => $montante
          )
        )
      )
    );

    try {

      ClassRodadas::verificarSePodeInvestir($user->id, $montante);
      $payment = new ClassPagamento();
      $order = $payment->setOrder($postParams);



      Transactions::create([
        'item_number' => $itemNumber,
        'item_name' => $itemName,
        'item_price' => $montante,
        'order_id' => $order->id,
        'fk_payer' => $idPayer,
        'payment_status' => "created"
      ]);

      return response()->json([
        'status' => 1,
        'data' => $order
      ]);
    } catch (ErrorException $e) {

      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function capture(Request $request)
  {
    $orderId = $request->order_id;
    $codigostartup = $request->codigoStartup;
    $porcentagemPeloMontante = str_replace(',', '.', str_replace('.', '', $request->porcentagemPeloMontante))+0.0;
    $user =  User::where('code_user', $request->codigoStartup)
      ->first();

    try {

      $payment = new ClassPagamento();
      $order = $payment->capturePayment($orderId);

      if ($order->status != "COMPLETED") {
        throw new Exception("Pagamento não completado");
      }

      $transacao = Transactions::where('order_id', $orderId)->first();

      $transacao->update([
        "payment_source" => 'card',
        "payment_source_card_last_digits" => $order->payment_source->card->last_digits,
        "payment_source_card_expiry" => $order->payment_source->card->expiry,
        "payment_source_card_brand" => $order->payment_source->card->brand,
      ]);

      $rodada = RodadasInvestimento::where('fk_startup', $user->id)
        ->where('estado', 'aberta')
        ->first();

      $valorObtido = $rodada->valor_obtido + $transacao->item_price;

      $rodada->update([
        "valor_obtido" => $valorObtido
      ]);

      if ($rodada->valor_objetivo == $rodada->valor_obtido) {

        $rodada->update([
          'estado' => 'fechada'
        ]);

        Startups::where('fk_user', $user->id)
          ->update([
            "estado_busca_invest" => 'nao'
          ]);
      }

      RodadasInvestidores::create([
        'fk_rodada' => $rodada->id,
        'fk_investidor' => $transacao->fk_payer,
        'valor_investido' => $transacao->item_price,
        'acoes_adquirida' => $porcentagemPeloMontante
      ]);

      event(new AtualizarEstadoRodada());

      return response()->json([
        'status' => 1,
        'data' => $order
      ]);
    } catch (ErrorException $e) {

      return response()->json([
        'status' => 0,
        'message' => $e->getMessage()
      ]);
    }
  }


  public function atualizarPorcentagemPeloMontante(Request $request)
  {
    $idRodada = $request->rodada_id;
    $valorMontante =  str_replace(',', '.', str_replace('.', '', $request->valorMontante)) + 0.0;
    

    $rodada = RodadasInvestimento::where('id', $idRodada)->first();
    $x = 100 * $valorMontante / $rodada->valor_objetivo;
    $y = (($x * $rodada->oferta_acoes)/100).'';
    $z = preg_replace("/(^0+(?=\d))|(,?0+$)/",'',number_format($y,12,',','.'));
    return response()->json(['porcentagem' => $z]);
  }
}
