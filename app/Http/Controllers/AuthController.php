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


        $incubadoraAceleradora = IncubadorasAceleradoras::where([
            ['nome','like',$dados['nome_incubadora_aceleradora']],
            ['nif',$dados['nif_incubadora_aceleradora']]
        ])
        ->first();

        if (empty($incubadoraAceleradora)) {

            $incubadoraAceleradora = IncubadorasAceleradoras::create([
                'nome' => $dados['nome_incubadora_aceleradora'],
                'nif' => $dados['nif_incubadora_aceleradora'],
                'outro' => 'yes'
            ]);
        }

        Startups::create([
            'fk_user' => $user->id,
            'nome' => $dados['nome'],
            'fk_setor_economico' => $dados['sector'],
            'fk_fase_desenvolvimento' => $dados['fase'],
            'contrato_incubadora_aceleradora' => $uploadFicheiro,
            'pitch_elevator' => $pitch,
            'logotipo' => "armazenamento/startups/img/img_standard_startup.png",
            'fk_incubadora_aceleradora' => $incubadoraAceleradora->id
        ]);

        return redirect()->intended("processamento_cadastro");
    }

    public function cadastrarInvestidor(Request $request)
    {



        $parametrosValidacao = [
            'tipo_investidor' => 'required',
            'nome_legal_investidor' => 'required',
            'email_investidor' => 'required|unique:users,email',
            'contrato_sociedade' => 'required'
        ];

        $mensagensValidacao = [
            'nome_legal_investidor.required' => 'Nome do investidor em falta',
            'email_investidor.required' => 'Email do investidor em falta',
            'email_investidor.unique' => 'Email do investidor já existe',
            'contrato_sociedade.required' => 'Contrato de sociedade em falta'
        ];

       
        if ($request->tipo_investidor == 2) {
            $parametrosValidacao['nif_investidor_juridico'] = 'required';
            $mensagensValidacao['nif_investidor_juridico.required'] = 'NIF do investidor em falta';
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




        $extensaoContratoSociedade = $request->file('contrato_sociedade')->extension();
        $nomeContratoSociedade = "contrato_sociedade{$user->id}.{$extensaoContratoSociedade}";
        $uploadContratoSociedade = $request->file('contrato_sociedade')->storeAs('armazenamento/investidor/contrato_sociedade', $nomeContratoSociedade);
        $uploadBilheteIdentidade = null;

        if ($request->tipo_investidor == 1) {

            $extensaoBilheteIdentidade = $request->file('bilhete_identidade_investidor')->extension();
            $nomeBilheteIdentidade = "bilhete_identidade{$user->id}.{$extensaoBilheteIdentidade}";
            $uploadBilheteIdentidade = $request->file('bilhete_identidade_investidor')->storeAs('armazenamento/investidor/bilhete_identidade', $nomeBilheteIdentidade);
        }


        Investidores::create([
            'fk_user' => $user->id,
            'nome' => $dados['primeiro_nome'],
            'sobrenome' => $sobrenome,
            'nif' => $nif,
            'tipo_entidade' => $dados['tipo_investidor'],
            'bilhete_identidade' => $uploadBilheteIdentidade,
            'contrato_sociedade' => $uploadContratoSociedade,
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

        return Redirect::to("new_login_page")->with('error', 'Dados incorrectos, tente novamente');
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
}
