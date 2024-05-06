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
            return response()->json('Erro ao enviar email',500);
        }

        $user->save();
        return response()->json($senha);
    }

    public function showRodadasPage(){
        return view('Admin/rodadas_captacao_admin');
    }
}
