<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Investidores;
use App\Startups;
use App\User;
use App\Own\User as MyUser;
use App\Own\Email;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use App\RodadasInvestidores;
use App\RodadasInvestimento;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function visualizarArquivoPerfil($tipo, $id, $documento)
    {
        abort_unless(Auth::check() && Auth::user()->tipo === 'admin', 403);

        $documentos = [
            'startup' => [
                'modelo' => Startups::class,
                'campos' => [
                    'nif' => 'nif',
                    'mvp' => 'mvp',
                ],
            ],
            'investidor' => [
                'modelo' => Investidores::class,
                'campos' => [
                    'bi' => 'bilhete_identidade',
                    'video' => 'video_investidor',
                ],
            ],
        ];

        abort_unless(isset($documentos[$tipo]['campos'][$documento]), 404);

        $modelo = $documentos[$tipo]['modelo'];
        $campo = $documentos[$tipo]['campos'][$documento];
        $perfil = $modelo::findOrFail($id);
        $arquivo = $perfil->{$campo};
        $disk = Storage::disk('public');

        abort_unless($disk->exists($arquivo), 404);

        return response()->file($disk->path($arquivo), [
            'Cache-Control' => 'private, no-store',
        ]);
    }

    public function index()
    {
        if (Auth::check()) {

            $startups = Startups::whereHas('user', function (Builder $query) {
                $query->where('estado', 'espera'); // 0 - ainda não avaliado, 1- aceite, 2-regeitado
            })
                ->orderBy('fk_user', 'desc')
                ->get();


            $investidores = Investidores::whereHas('user', function (Builder $query) {
                $query->where('estado', 'espera'); // 0 - ainda não avaliado, 1- aceite, 2-regeitado
            })
                ->orderBy('fk_user', 'desc')
                ->get();



            return view('Admin/painel', compact('startups', 'investidores'));
        }

        return Redirect::to("new_home_page")->with('error', 'Faça Login');
    }


    public function atualizarEstadoUser(Request $request)
    {
        abort_unless(Auth::check() && Auth::user()->tipo === 'admin', 403);

        if (!$request->ajax()) {
            return response()->json(['message' => 'A requisição deve ser AJAX.'], 400);
        }

        $action = $request->input('action_');
        if (!in_array($action, ['Aceitar', 'Regeitar'], true)) {
            return response()->json(['message' => 'Ação inválida.'], 422);
        }

        $user = User::findOrFail($request->input('id'));
        $status = $action === 'Aceitar' ? 1 : 0;
        $user->estado = $status ? 'aceite' : 'regeitado';

        $senha = MyUser::gerarSenha($user->id);
        MyUser::updatePassword($user, $senha);

        try {
            Email::send($user->email, $user->tipo, $senha, $status);
        } catch (Exception $e) {
            return response()->json([
                'estado' => $user->estado,
                'email_enviado' => false,
                'mensagem' => 'Estado atualizado, mas não foi possível enviar o email de notificação.',
            ]);
        }

        return response()->json([
            'estado' => $user->estado,
            'email_enviado' => true,
        ]);
    }

    public function showRodadasPage()
    {
        return view('Admin/rodadas_captacao_admin');
    }

    public function showRodadaPage(Request $request)
    {
        $canInvest = 0;
        $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->get();
        $rodada = RodadasInvestimento::where('id', $request->id_rodada)->first();

        $rodadaInvestidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)
            ->where(function ($query) {
                return $query->whereNull('contrato_mutou')
                    ->orWhere('status_contrato_investidor', '!=', 4)
                    ->orWhere('status_contrato_startup', '!=', 4)
                    ->orWhereNull('comprovativo_assinatura')
                    ->get();
            })
            ->get();

        $canInvest = $rodadaInvestidores->count();

        $rodadaId = $rodada->id;

        return view('Admin/pagina_da_rodada_admin', compact('investidores', 'rodada', 'rodadaId', 'canInvest'))->render();
    }

    public function loadBtnTransferComprovativo(Request $request) {
        $rodadaId = $request->rodadaId;
        $html = null;
        $case = 0;

        $rodadaInvestidores = RodadasInvestidores::where('fk_rodada', $rodadaId)
            ->where(function ($query) {
                return $query->whereNull('contrato_mutou')
                    ->orWhere('status_contrato_investidor', '!=', 4)
                    ->orWhere('status_contrato_startup', '!=', 4)
                    ->orWhereNull('comprovativo_assinatura')
                    ->get();
            })
            ->get();

        $rodada = RodadasInvestimento::where('id', $rodadaId)
        ->first();

        if ($rodadaInvestidores->count() == 0 && $rodada->estado == 'fechada')
            $html = view('Admin/btn_send_money_to_startup', compact('rodada'))->render();
        else if($rodada->estado == 'sucedida')
            $html = view('Admin/comprovativo_send_money_to_startup', compact('rodada'))->render();
        else
            $case = 1;
        return response()->json([
            'html' => $html,
            'case' => $case
        ], 200);
    }

    public function sendMoneyToStartup(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'identify' => 'required|numeric',
                'comprovativo_transferencia' => 'required|file|mimes:pdf'
            ],
            [
                'identify.required' => 'Id da Rodada em falta',
                'comprovativo_transferencia.required' => 'Comprovativo em Falta',
                'comprovativo_transferencia.file' => 'Comprovativo deve ser Arquivo',
                'comprovativo_transferencia.mimes' => 'Comprovativo deve ser Arquivo PDF'
            ]
        );

        $extensao = $request->file('comprovativo_transferencia')->extension();



        $newName = "comprovativo_send{$request->identify}.{$extensao}";
        $path = $request->file('comprovativo_transferencia')->storeAs('armazenamento/comprovativo_send_money_to_startup', $newName);

        RodadasInvestimento::where('id', $request->identify)
            ->where('estado', 'fechada')
            ->update([
                'estado' => 'sucedida',
                'comprovativo' => $path,
                'status_investimento' => 3
            ]);
        return response()->json(NULL, 200);
    }
}
