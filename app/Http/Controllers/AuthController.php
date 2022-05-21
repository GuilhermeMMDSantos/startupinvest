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
            'email' => 'required|unique:users',
            'sector' => 'required',
            'fase' => 'required',
            'pitch_line1' => 'required',
            'pitch_line2' => 'required',
            'pitch_line3' => 'required',
            'pitch_line4' => 'required',
            'nome_incubadora_aceleradora' => 'required',
            'nif_incubadora_aceleradora' => 'required',
            'contrato_aceleracao_incubacao' => 'required',

        ], [
            'nome.required' => 'Nome da Startup em falta',
            'nome.unique' => 'Nome da Startup já existe',
            'email.required' => 'Email da Startup em falta',
            'email.unique' => 'Email da Startup já existe',
            'sector.required' => 'Sector econômico em falta',
            'fase.required' => 'Fase de desenvolvimento em falta',
            'pitch_line1' => 'Descrição do tipo produto em falta',
            'pitch_line2' => 'Descrição do publico alvo em falta',
            'pitch_line3' => 'Descrição da solução em falta',
            'pitch_line4' => 'Descrição do diferencial em falta',
            'nome_incubadora_aceleradora.required' => 'Nome Incubadora/Aceleradora em falta',
            'nif_incubadora_aceleradora.required' => 'NIF  Incubadora/Aceleradora em falta',
            'contrato_aceleracao_incubacao.required' => 'Contrato de registro em falta',

        ]);


        if ($validador->fails()) {
            return redirect()
                ->back()
                ->withErrors($validador)
                ->withInput($request->all());
        }

        $codeUser = "";
        $dados = $request->all();
        $codeUser = $codeUser . '' . strtolower($dados['nome']) . '' . Carbon::now()->format('mYdhsm');

        $user = $this->create($dados, 'startup', $codeUser);



        $pitch = "A##{$dados['nome']}##está construindo##{$dados['pitch_line1']}##para ajudar##{$dados['pitch_line2']}##
        a##{$dados['pitch_line3']}##com##{$dados['pitch_line4']}";

        $extensaoArquivo = $request->file('contrato_aceleracao_incubacao')->extension();
        $nomeArquivo = "contrato{$user->id}.{$extensaoArquivo}";

        $uploadFicheiro = $request->file('contrato_aceleracao_incubacao')->storeAs('armazenamento/startups/contrato_com_incubadora_aceleradora', $nomeArquivo);

        if ($dados['id_incubadora_aceleradora'] == 0) {

            $incubadoraAceleradora = IncubadorasAceleradoras::create([
                'nome' => $dados['nome_incubadora_aceleradora'],
                'nif' => $dados['nif_incubadora_aceleradora'],
                'outro' => 'yes'
            ]);

            $dados['id_incubadora_aceleradora'] = $incubadoraAceleradora->id;
        }

        Startups::create([
            'fk_user' => $user->id,
            'nome' => $dados['nome'],
            'fk_setor_economico' => $dados['sector'],
            'fk_fase_desenvolvimento' => $dados['fase'],
            'contrato_incubadora_aceleradora' => $uploadFicheiro,
            'pitch_elevator' => $pitch,
            'logotipo' => "armazenamento/startups/img/img_standard_startup.png",
            'fk_tipo_negocio' => $dados['busnessType'],
            'fk_incubadora_aceleradora' => $dados['id_incubadora_aceleradora']
        ]);

        return redirect()->intended("processamento_cadastro");
    }

    public function cadastrarInvestidor(Request $request)
    {
 

       $parametrosValidacao = [
        'primeiro_nome' => 'required',
        'email_investidor' => 'required|unique:users,email',
        'pacto_social' => 'required'
       ]; 

       $mensagensValidacao = [
        'primeiro_nome.required' => 'Nome do investidor em falta',
        'email_investidor.required' => 'Email do Invetidor em falta',
        'email_investidor.unique' => 'Email do Investidor já existe',
        'pacto_social.required' => 'Contrato de sociedade em falta'
       ];

       if($request->tipo_investidor == 2){
        $parametrosValidacao['segundo_nome'] = 'required';
        $mensagensValidacao['segundo_nome.required'] = 'Sobrenome do investidor em falta';
       }

       if($request->tipo_investidor == 2){
        
        $parametrosValidacao['bilhete_identidade_investidor'] = 'required';
        $mensagensValidacao['bilhete_identidade_investidor.required'] = 'Bilhete de identidade do investidor em falta';
       }

       if($request->tipo_investidor == 1){
        $parametrosValidacao['nif'] = 'required';
        $mensagensValidacao['nif.required'] = 'NIF do investidor em falta';
       }

        $validador = Validator::make(
            $request->all(),
            $parametrosValidacao,
            $mensagensValidacao
        );


        if ($validador->fails()) {
            return redirect()
                ->back()
                ->withErrors($validador)
                ->withInput($request->all());
        }


        $codeUser = "";
        $dados = $request->all();
        $codeUser = $codeUser . '' . strtolower($dados['primeiro_nome']);

        $nif = null;
        $sobrenome = null;

        if (isset($dados['nif']))
            $nif = $dados['nif'];

        if (isset($dados['segundo_nome'])) {
            $sobrenome = $dados['segundo_nome'];
            $codeUser = $codeUser . '' . strtolower($sobrenome);
        }

        $codeUser = $codeUser . '' . Carbon::now()->format('mYdhsm');
        $user = $this->create($dados, 'investidor', $codeUser);

        $extensaoArquivo = $request->file('video_validar_investidor')->extension();
        $nomeArquivo = "video{$user->id}.{$extensaoArquivo}";

        $uploadFicheiro = $request->file('video_validar_investidor')->storeAs('armazenamento/investidor/videos', $nomeArquivo);




        Investidores::create([
            'fk_user' => $user->id,
            'nome' => $dados['primeiro_nome'],
            'sobrenome' => $sobrenome,
            'nif' => $nif,
            'tipo_entidade' => $dados['tipo_investidor'],
            'video_validar' => $uploadFicheiro,
            'img' => 'armazenamento/investidor/img/img_standard_investidor.png'
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

        request()->validate([
            'email_login' => 'required',
            'password_login' => 'required'
        ]);

        $dados = $request->only('email_login', 'password_login');
        $status = Auth::attempt(['email' => $dados['email_login'], 'password' => $dados['password_login'], 'estado' => 'aceite']);



        if ($status) {
            if (Auth::user()->tipo == 'admin') {
                return redirect()->intended("paineladmin");
            }
            return redirect()->intended("stackholder_startup");
        }

        return Redirect::to("home")->with('error', 'Credenciais erradas');
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
        return Redirect("home");
    }
}
