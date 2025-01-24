<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\RodadasInvestimento;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\ReferenciasPagamento;
use Illuminate\Support\Carbon;

class PagamentosController extends Controller
{

  public function index()
  {
    return view('Admin.pagamentos');
  }


  public function setRefPayment(Request $request, PaymentService $paymentService)
  {

    try {

      $validation = Validator::make($request->all(), [
        'valor_a_investir' => 'required',
        'porcentagem_por_valor' => 'required',
        'rodada' => 'required|integer'
      ], [
        'valor_a_investir.required' => 'Informe o quanto deseja investir.',
        'porcentagem_por_valor.required' => 'Porcentagem em falta.',
        'rodada.required' => 'Rodada em Falta.',
        'rodada.integer' => 'Valor da rodada deve ser inteiro.'
      ]);

      if ($validation->fails())
        throw new ValidationException($validation);

      $rodadaId = $request->rodada;
      $rodada = RodadasInvestimento::where('id', $rodadaId)->first();
      $currentUser = Auth::user();
      $amount = str_replace(',', '.', str_replace('.', '', $request->valor_a_investir));
      $porcentage = str_replace(',', '.', str_replace('.', '', $request->porcentagem_por_valor));


      if (!is_numeric($amount) || !is_numeric($porcentage))
        throw ValidationException::withMessages(['rodada' => ['Informou valores não numéricos']]);
      $paymentService->checkInvestmentRules($rodada, $amount, $porcentage);

      
      $data = [
        'amount' => $amount , 
        'end_datetime' => Carbon::now()->addHours(24), 
        'custom_fields' => []
      ];

      //PARA EVITAR O CASO EM QUE MUITA GENTE ESTÁ A FAZER PAGAMENTO. ANTES DE GERAR UMA REFERENCIA DE PAGAMENTO DEVE SE VERIFICAR SE 
      //O NUMERO DE REFERENCIAS GERADAS(PENDENTES OU PROCESSADAS) PARA RODADA É MENOR QUE O NÚMERO QUE O NUMERO DE INVESTIDORES DESEJADOS PARA A RODADA
      //CASO SEJA MAIOR OU IGUAL, NÃO GERA NOVA REFERENCIA
      $idReference = $paymentService->createRefPayment($data);
      
      ReferenciasPagamento::create([
        'referencia' => $idReference,
        'fk_rodada_investimento' => $rodadaId,
        'fk_investidor' => $currentUser->id,
        'valor_monetario' => $amount,
        'status' => 'pendente'
      ]);
      
      return response()->json(null, 200);
    } catch (ValidationException $e) {
      return response()->json(['errors' => $e->errors()], 422);
    } catch (Exception $e) {
      return response()->json(['errors' => $e->getMessage()], 500);
    }
  }

  public function atualizarPorcentagemPeloMontante(Request $request)
  {
    $idRodada = $request->rodada_id;
    $valorMontante =  str_replace(',', '.', str_replace('.', '', $request->valorMontante)) + 0.0;


    $rodada = RodadasInvestimento::where('id', $idRodada)->first();
    $x = 100 * $valorMontante / $rodada->valor_objetivo;
    $y = (($x * $rodada->oferta_acoes) / 100) . '';
    $z = preg_replace("/(^0+(?=\d))|(,?0+$)/", '', number_format($y, 12, ',', '.'));
    return response()->json(['porcentagem' => $z, 'valorMontante' => $valorMontante]);
  }
}
