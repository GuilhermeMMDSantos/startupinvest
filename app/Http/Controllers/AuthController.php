<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\User;
use App\Startups;
use App\Investidores;

class AuthController extends Controller
{
    public function cadastrarStartup(Request $request)
    {


        $validador = Validator::make($request->all(), [
            'nome' => 'required|unique:startups',
            'email' => 'required|unique:users',
            'sector' => 'required',
            'fase' => 'required',
            'comprovativo_registo' => 'required',
            'pitch_line1' => 'required',
            'pitch_line2' => 'required',
            'pitch_line3' => 'required',
            'pitch_line4' => 'required'

        ], [
            'nome.required' => 'Nome da Startup em falta',
            'nome.unique' => 'Nome da Startup já existe',
            'email.required' => 'Email da Startup em falta',
            'email.unique' => 'Email da Startup já existe',
            'sector.required' => 'Sector econômico em falta',
            'fase.required' => 'Fase de desenvolvimento em falta',
            'comprovativo_registo.required' => 'Comprovativo de registro em falta',
            'pitch_line1' => 'Descrição do tipo produto em falta',
            'pitch_line2' => 'Descrição do publico alvo em falta',
            'pitch_line3' => 'Descrição da solução em falta',
            'pitch_line4' => 'Descrição do diferencial em falta',

        ]);


        if ($validador->fails()) {
            return redirect()
                ->back()
                ->withErrors($validador)
                ->withInput($request->all());
        }


        $dados = $request->all();


        $user = $this->create($dados,'startup');



        $pitch = "A {$dados['nome']} está construindo {$dados['pitch_line1']} para ajudar {$dados['pitch_line2']}
        a {$dados['pitch_line3']} com {$dados['pitch_line4']}";

        $extensaoArquivo = $request->file('comprovativo_registo')->extension();
        $nomeArquivo = "comprovativo{$user->id}.{$extensaoArquivo}";

        $uploadFicheiro = $request->file('comprovativo_registo')->storeAs('armazenamento/startups/comprovativos', $nomeArquivo);



        Startups::create([
            'id_user' => $user->id,
            'nome' => $dados['nome'],
            'setor_atividade' => $dados['sector'],
            'fase_desenvolvimento' => $dados['fase'],
            'comprovativo_registo' => $uploadFicheiro,
            'pitch_elevator' => $pitch,
            'img' => "armazenamento/startups/img/img2.jpg"
        ]);

        return redirect()->intended("processamentocadastro");
    }

    public function cadastrarInvestidor(Request $request)
    {

        $validador = Validator::make(
            $request->all(),
            [
                'primeiro_nome' => 'required', //sobrenome e o nif sao opcionais
                'email_investidor' => 'required|unique:users,email',
                'nacionalidade_inv' => 'required',
            ],
            [
                'primeiro_nome.required' => 'Nome do investidor em falta',
                'email_investidor.required' => 'Email do Invetidor em falta',
                'email_investidor.unique' => 'Email do Investidor já existe',
                'nacionalidade_inv.required' => 'Nacionalidade do inv. em falta '
            ]
        );


        if ($validador->fails()) {
            return redirect()
                ->back()
                ->withErrors($validador)
                ->withInput($request->all());
        }

        $dados = $request->all();
        
 

        $user = $this->create($dados,'investidor');



        $nif = null;
        $sobrenome = null;

        if (isset($dados['nif']))
            $nif = $dados['nif'];

        if (isset($dados['segundo_nome']))
            $sobrenome = $dados['segundo_nome'];

            Investidores::create([
            'id_user' => $user->id,
            'nome' => $dados['primeiro_nome'],
            'sobrenome' => $sobrenome,
            'nif' => $nif,
            'id_nacionalidade' => $dados['nacionalidade_inv'],
            'id_tipo_entidade' => $dados['tipo_investidor']
        ]);

        return redirect()->intended("processamentocadastro");
    }

    public function create(array $dados, $tipo)
    {
        $email = null;
        if (isset($dados['email']))
            $email = $dados['email'];
        else
            $email = $dados['email_investidor'];

        return User::create([
            'email' => $email,
            'password' => Hash::make('12345'),
            'estado' => 'aguardando', // em processamento,aceite, negato 
            'tipo' => $tipo
        ]);
    }

    public function loginuser(Request $request)
    {


        request()->validate([
            'email_login' => 'required',
            'password_login' => 'required'
        ]);

        $dados = $request->only('email_login', 'password_login');
        $status = Auth::attempt(['email' => $dados['email_login'], 'password' => $dados['password_login'], 'estado' => 'aceite']);



        if ($status) {
            if(Auth::user()->tipo == 'admin'){
                return redirect()->intended("paineladmin");
            }
            return redirect()->intended("ecostartup");
        }

        return Redirect::to("home")->with('error', 'Credenciais erradas');
    }

  

    public function logoutUser()
    {
        Session::flush();
        Auth::logout();
        return Redirect("home");
    }

     
}
