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
use App\RodadasInvestidores;
use Illuminate\Support\Carbon;
use App\Notifications;
use App\Notifications\Notificao;
use App\Events\ParticipacaoNaRodada;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

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
        'amount' => $amount,
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

  public function atualizarPorcentagemPeloMontante(Request $request, PaymentService $paymentService)
  {
    $idRodada = $request->rodada_id;
    $valorMontante =  str_replace(',', '.', str_replace('.', '', $request->valorMontante)) + 0.0;

    $rodada = RodadasInvestimento::where('id', $idRodada)->first();
    $porcentageCalculada = $paymentService->porcentageCalculo($valorMontante, $rodada->valor_objetivo, $rodada->oferta_acoes);
    $z =  preg_replace("/(^0+(?=\d))|(,?0+$)/", '', number_format($porcentageCalculada, 12, ',', '.'));
    return response()->json(['porcentagem' => $z, 'valorMontante' => $valorMontante]);
  }

  public function getWebhook(Request $request, PaymentService $paymentService)
  {
    $data = $request->all();

    try {
      DB::transaction(function () use ($paymentService, $data) {
       
        $referenciaObj = ReferenciasPagamento::where('referencia', $data['reference_id'])->first();
        
        if ($referenciaObj == null)
          return response()->json([], 500);
        
        $referenciaObj->update(["status" => "processada"]);

        

        $rodadaInvestimentoObj = RodadasInvestimento::where('id', $referenciaObj->fk_rodada_investimento)->first();
        $dataToUpdate["valor_obtido"] = $rodadaInvestimentoObj->valor_obtido + $referenciaObj->valor_monetario;
        if ($dataToUpdate["valor_obtido"] == $rodadaInvestimentoObj->valor_objetivo)
          $dataToUpdate["estado"] = "fechada";
        $rodadaInvestimentoObj->update($dataToUpdate);
        
        $acoeAdquirida = $paymentService->porcentageCalculo($referenciaObj->valor_monetario, $rodadaInvestimentoObj->valor_objetivo, $rodadaInvestimentoObj->oferta_acoes);

        RodadasInvestidores::create([
          'fk_rodada' => $rodadaInvestimentoObj->id,
          'fk_investidor' => $referenciaObj->fk_investidor,
          'valor_investido' => $referenciaObj->valor_monetario,
          'acoes_adquirida' => $acoeAdquirida,
          'contrato_mutou' => null,
          'status_contrato_investidor' => null,
          'status_contrato_startup' => null,
          'status_investimento' => 0,
          'contrato_mutou_aprovado' => null
        ]);

        $allInvestorsInRound = RodadasInvestidores::where('fk_rodada', $rodadaInvestimentoObj->id)
          ->where('fk_investidor', "<>", $referenciaObj->fk_investidor)
          ->get();

        $allInvestorsInRound->each(function ($investor) use ($rodadaInvestimentoObj) {

          Notifications::create([
            'message' => "Investimento efetuado a startup {$rodadaInvestimentoObj->startup->nome}",
            'fk_user_distination' => $investor->investidor->fk_user,
            'fk_user_origin' => $rodadaInvestimentoObj->fk_startup,
            'status' => 'nao_visto',
            'tipo' => 'foi_investido'
          ]);

          $notificacoes = Notifications::where('fk_user_distination', $investor->investidor->fk_user)
            ->where('status', 'nao_visto')
            ->get();

          $qtdNotification = (int)count($notificacoes);

          $investor->investidor->user->notify(new Notificao($qtdNotification));
        });


        Notifications::create([
          'message' => "{$rodadaInvestimentoObj->startup->nome}, Recebeu Investimento",
          'fk_user_distination' => $rodadaInvestimentoObj->fk_startup,
          'fk_user_origin' => $rodadaInvestimentoObj->fk_startup,
          'status' => 'nao_visto',
          'tipo' => 'foi_investido'
        ]);

        $notificacoes = Notifications::where('fk_user_distination', $rodadaInvestimentoObj->fk_startup)
          ->where('status', 'nao_visto')
          ->get();

        $rodadaInvestimentoObj->startup->user->notify(new Notificao($notificacoes->count()));

        event(new ParticipacaoNaRodada($rodadaInvestimentoObj->fk_startup));
        event(new ParticipacaoNaRodada($referenciaObj->fk_investidor));

        return response()->json(['sucesso'], 201);
      });
    } catch (Exception $e) {
      Log::info($e);
      return response()->json([
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
