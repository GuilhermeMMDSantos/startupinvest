<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

        if (!request()->ajax()) {
            Session::flush();
            Auth::logout();
            return Redirect("new_home_page");
        }

        $id_user = $request->id;

        $status = 0;
        $senha = null;
        $user = User::find($id_user);


        if ($request->action_ == 'Aceitar') {
            $user->estado = 'aceite';
            $status = 1;
        } else if ($request->action_ == 'Regeitar') {
            $user->estado = 'regeitado';
            $status = 0;
        }

        try {
            $senha = MyUser::gerarSenha($user->id);
            MyUser::updatePassword($user, $senha);
            Email::send($user->email, $user->tipo, $senha, $status);
        } catch (Exception $e) {
            $user->estado = 'espera';
            $user->save();
            return response()->json('Erro ao enviar email', 500);
        }

        $user->save();
        return response()->json($senha);
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
                'comprovativo' => $path
            ]);
        return response()->json(NULL, 200);
    }
}
