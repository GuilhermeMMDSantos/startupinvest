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
use App\Own\ClassPagamento;
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

  public function investirComPaypal(Request $request)
  {

    $pagamento = new ClassPagamento();

    /*  $dados = '{
            "intent": "sale",
            "payer": {
              "payment_method": "paypal"
            },
            "transactions": [
              {
                "amount": {
                  "total": "30.11",
                  "currency": "USD",
                  "details": {
                    "subtotal": "30.00",
                    "tax": "0.07",
                    "shipping": "0.03",
                    "handling_fee": "1.00",
                    "shipping_discount": "-1.00",
                    "insurance": "0.01"
                  }
                },
                "description": "The payment transaction description.",
                "custom": "EBAY_EMS_90048630024435",
                "invoice_number": "48787589673",
                "payment_options": {
                  "allowed_payment_method": "INSTANT_FUNDING_SOURCE"
                },
                "soft_descriptor": "ECHI5786786",
                "item_list": {
                  "items": [
                    {
                      "name": "hat",
                      "description": "Brown hat.",
                      "quantity": "5",
                      "price": "3",
                      "tax": "0.01",
                      "sku": "1",
                      "currency": "USD"
                    },
                    {
                      "name": "handbag",
                      "description": "Black handbag.",
                      "quantity": "1",
                      "price": "15",
                      "tax": "0.02",
                      "sku": "product34",
                      "currency": "USD"
                    }
                  ],
                  "shipping_address": {
                    "recipient_name": "Brian Robinson",
                    "line1": "4th Floor",
                    "line2": "Unit #34",
                    "city": "San Jose",
                    "country_code": "US",
                    "postal_code": "95131",
                    "phone": "011862212345678",
                    "state": "CA"
                  }
                }
              }
            ],
            "note_to_payer": "Contact us for any questions on your order.",
            "redirect_urls": {
              "return_url": "https://example.com/return",
              "cancel_url": "https://example.com/cancel"
            }
          }';
*/
    $pega = $pagamento->getToken();
    dd($pega);
    // $getResponse =  $pagamento->setInvoce($dados);
    // return response()->json($getResponse);
  }


  public function teste()
  {
    return view('teste');
  }

  public function orders(Request $request)
  {
    // Product Details 
    $itemNumber = "23";
    $itemName = "Startup invest";
    $itemPrice = 400000;
    $currency = "USD";

    $postParams = array(
      "intent" => "CAPTURE",
      "purchase_units" => array(
        array(
          "custom_id" => $itemNumber,
          "description" => $itemName,
          "amount" => array(
            "currency_code" => $currency,
            "value" => $itemPrice
          )
        )
      )
    );

    $payment = new ClassPagamento();
    $order = $payment->setOrder($postParams);

    return response()->json([
      'status' => 1,
      'data' => $order
    ]);
  }

  public function capture(Request $request)
  {
    $orderId = $request->order_id;
    $payment = new ClassPagamento();
    $order = $payment->capturePayment($orderId);

    return response()->json([
      'status' => 1,
      'data' => $order
    ]);

  }
}
