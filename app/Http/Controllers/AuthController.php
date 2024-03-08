<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailSenha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\User;
use App\Startups;
use App\Investidores;
use App\IncubadorasAceleradoras;

class AuthController extends Controller
{
    public function cadastrarStartup(Request $request)
    {


        $validador = Validator::make($request->all(), [
            'nome' => 'required|unique:startups',
            'nif' => 'required|unique:startups',
            'email' => 'required|unique:users',
            'sector' => 'required',
            'fase' => 'required',
            'mvp' => 'required',
            'pitch_line1' => 'required',
            'pitch_line2' => 'required',
            'pitch_line3' => 'required',
            'pitch_line4' => 'required',

        ], [
            'nome.required' => 'Nome da Startup em falta',
            'nome.unique' => 'Nome da Startup já existe',
            'nif.required' => 'NIF da Startup em falta',
            'nif.unique' => 'NIF da Startup já existe',
            'mvp' => 'MVP em falta',
            'email.required' => 'Email da Startup em falta',
            'email.unique' => 'Email da Startup já existe',
            'sector.required' => 'Sector econômico em falta',
            'fase.required' => 'Fase de desenvolvimento em falta',
            'pitch_line1' => 'Descrição do tipo produto em falta',
            'pitch_line2' => 'Descrição do publico alvo em falta',
            'pitch_line3' => 'Descrição da solução em falta',
            'pitch_line4' => 'Descrição do diferencial em falta',

        ]);


        if ($validador->fails()) {
            return redirect()
                ->back()
                ->with('tipo', 'startup')
                ->withErrors($validador)
                ->withInput($request->all());
        }

        $dados = $request->all();
        $codeUser = strtolower($dados['nome']) . '' . Carbon::now()->format('mYdhsm');

        $user = $this->create($dados, 'startup', $codeUser);



        $pitch = "A##{$dados['nome']}##está construindo##{$dados['pitch_line1']}##para ajudar##{$dados['pitch_line2']}##
        a##{$dados['pitch_line3']}##com##{$dados['pitch_line4']}";

        $nifUploaded = $this->saveFile($request, 'nif', 'armazenamento/startups/nif');
        $mvpUploaded = $this->saveFile($request, 'mvp', 'armazenamento/startups/mvp');

        Startups::create([
            'fk_user' => $user->id,
            'nome' => $dados['nome'],
            'nif' =>  $nifUploaded,
            'fk_setor_economico' => $dados['sector'],
            'fk_fase_desenvolvimento' => $dados['fase'],
            'mvp' => $mvpUploaded,
            'pitch_elevator' => $pitch,
            'logotipo' => "armazenamento/startups/img/img_standard_startup.png"
        ]);

        return redirect()->intended("processamento_cadastro");
    }

    public function cadastrarInvestidor(Request $request)
    {
        $dados = $request->all();
        $validador = Validator::make(
            $dados,
            [
                'nome' => 'required',
                'sobrenome' => 'required',
                'bi_investidor' => 'required',
                'email_investidor' => 'required|unique:users,email',
                'video_investidor' => 'required'
            ],
            [
                'nome.required' => 'Nome do Investidor em falta',
                'sobrenome.required' => 'Sobrenome do Investidor em falta',
                'bi_investidor.required' => ' BI em falta',
                'email_investidor.required' => 'Email do investidor em falta',
                'email_investidor.unique' => 'Email do investidor já existe',
                'video_investidor.required' => 'Video em falta'
            ]
        );

        if ($validador->fails()) {
            return redirect()
                ->back()
                ->with('tipo', 'investidor')
                ->withErrors($validador)
                ->withInput($dados);
        }


        $videoUploaded = null;
        $biUploaded = null;

        $biUploaded = $this->saveFile($request, 'bi_investidor', 'armazenamento/investidor/bilhete_identidade');
        $videoUploaded = $this->saveFile($request, 'video_investidor', 'armazenamento/investidor/videos');



        $codeUser = strtolower($dados['nome']) . '' . Carbon::now()->format('ddmmYYhis');
        $user = $this->create($dados, 'investidor', $codeUser);


        Investidores::create([
            'fk_user' => $user->id,
            'nome' => $dados['nome'],
            'sobrenome' => $dados['sobrenome'],
            'bilhete_identidade' => $biUploaded,
            'video_investidor' => $videoUploaded,
            'foto' => 'armazenamento/investidor/img/img_standard_investidor.png'
        ]);

        return redirect()->intended("processamento_cadastro");
    }

    public function create(array $dados, $tipo, $codeUser)
    {
        $email = null;
        if (isset($dados['email']))
            $email = $dados['email'];
        else
            $email = $dados['email_investidor'];

        return User::create([
            'email' => $email,
            'password' => Hash::make('12345'),
            'estado' => 'espera',
            'tipo' => $tipo,
            'code_user' => $codeUser
        ]);
    }



    public function loginuser(Request $request)
    {
        $validador = Validator::make(
            $request->all(),
            [
                'email_login' => 'required',
                'password_login' => 'required'
            ],
            [
                'email_login.required' => 'Email em falta',
                'password_login.required' => 'Senha em falta'
            ]
        );

        if ($validador->fails()) {
            return redirect()
                ->back()
                ->withErrors($validador);
        }

        $dados = $request->only('email_login', 'password_login');
        $status = Auth::attempt(['email' => $dados['email_login'], 'password' => $dados['password_login'], 'estado' => 'aceite']);



        if ($status) {
            if (Auth::user()->tipo == 'admin') {
                return redirect()->intended("paineladmin");
            }
            return redirect()->intended("stackholder_startup");
        }

        return Redirect::to("new_login_page")->with('error', 'Credenciais erradas');
    }


    public function sendMail()
    {
        $to = "guiframart1@gmail.com";
        Mail::to($to)->send(new EmailSenha);

        if (Mail::failures() != 0) {
            return "Enviado com sucesso";
        }
        return "Falha ao enviar";
    }


    public function logoutUser()
    {
        Session::flush();
        Auth::logout();
        return Redirect("/");
    }

    public function saveFile(Request $request, $name, $caminho)
    {

        $data = Carbon::now()->format('ddmmYYhis');

        $extensaoArquivo = $request->file("{$name}")->extension();
        $nomeArquivo = "{$name}{$data}.{$extensaoArquivo}";

        $uploadFicheiro = $request->file("{$name}")->storeAs("{$caminho}", $nomeArquivo);

        return $uploadFicheiro;
    }
}
