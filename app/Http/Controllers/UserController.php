<?php

namespace App\Http\Controllers;

use App\Fases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Startups;
use App\Investidores;
use App\InvestidoresDaStartup;
use App\User;
use App\RodadasInvestimento;
use App\Setores;
use App\TipoBusness;
use Exception;
use SebastianBergmann\Environment\Console;
use App\CertificadosFormacao;
use App\AreasFormacao;
use App\CargosExecutivo;

class UserController extends Controller
{

    public function loadStartups(Request $request)
    {



        /*  if (!request()->ajax()) {
            Session::flush();
            Auth::logout();
            return Redirect("home");
        } */



        $dataAtual = Carbon::now()->format('Y-m-d H:m:s');
        $faseDesenvolvimento = $request->faseDesenvolvimento;
        $setorEconomico = $request->setorEconomico;
        $tipoNegocio = $request->tipoNegocio;
        $nomeStartup = $request->nomeStartup;



        $haveFaseDesenvolvimento = $faseDesenvolvimento != 0;
        $haveSetorEconomico = $setorEconomico != 0;
        $haveTipoNegocio = $tipoNegocio != 0;
        $haveNomeStartup = !empty($nomeStartup);



        $startupsCards =  Startups::with(['setor', 'fase', 'tipobusnessfunc', 'user', 'rodadaAtual' => function ($query1) {
            $query1->with('investidores')
                ->select('*', DB::raw('TIMESTAMPDIFF(DAY,NOW(),data_limite) AS tempo_restante'))
                ->get();
        }])
            ->whereHas('user', function ($query) {
                $query->where('estado', 'aceite');
            })
            ->where('fk_user', '!=', Auth::user()->id)
            ->when($haveFaseDesenvolvimento, function ($query) use ($faseDesenvolvimento) {
                return $query->where('fk_fase_desenvolvimento', $faseDesenvolvimento);
            })
            ->when($haveSetorEconomico, function ($query) use ($setorEconomico) {
                return $query->where('fk_setor_economico', $setorEconomico);
            })
            ->when($haveTipoNegocio, function ($query) use ($tipoNegocio) {
                return $query->where('fk_tipo_negocio', $tipoNegocio);
            })
            ->when($haveNomeStartup, function ($query2) use ($nomeStartup) {
                return $query2->where('nome', 'like', $nomeStartup . '%');
            })
            ->get();


        $returnHtml = view('carregamentos.startup_cards', compact('startupsCards', 'dataAtual'))->render();
        return response()->json($returnHtml);
    }

    public function filtrarStartups(Request $request)
    {
        if (!request()->ajax()) {
            Session::flush();
            Auth::logout();
            return Redirect("home");
        }  // E se eu criar um middleware

        $fasesSelecionadas = $request->fases;
        $setoresSelecionados = $request->setores;
        $tiposNegocioSelecionados = $request->typeBusness;
        $value_search_filtro = $request->search;

        $startupsCards = Startups::with(['setor', 'fase', 'tipobusnessFunc'])
            ->whereHas('user', function ($query) {
                $query->where('estado', 'aceite');
            })
            ->whereIn('fk_setor_economico', $setoresSelecionados)
            ->whereIn('fk_fase_desenvolvimento', $fasesSelecionadas)
            ->whereIn('fk_tipo_negocio', $tiposNegocioSelecionados)
            ->when($value_search_filtro, function ($query, $value_search_filtro) {
                return $query->where('nome', 'like', '%' . $value_search_filtro . '%');
            })
            ->where('fk_user', '!=', Auth::user()->id)
            ->get();

        $returnHtml = view('carregamentos.startup_cards', compact('startupsCards'))->render();
        return response()->json($returnHtml);
    }

    public function showPerfil($codeUser)
    {

        $user = User::where('code_user', $codeUser)->first();
        $myProfile = ($user->id == Auth::user()->id);

        if ($user->tipo == 'startup') {

            $startup =  Startups::with(['setor', 'fase', 'tipobusnessfunc', 'user'])
                ->where('fk_user', $user->id)
                ->first();

            $rodada = RodadasInvestimento::with(['investidores', 'finalidadesInvestimento'])
                ->select('*', DB::raw('TIMESTAMPDIFF(DAY,NOW(),data_limite) AS tempo_restante'))
                ->where('fk_startup', $startup->fk_user)
                ->where('estado', 'aberta')
                ->first();

            $investidoresDaStartup = DB::table('investidores_da_startup')
                ->where('fk_startup', $startup->fk_user)
                ->get();

            $membrosEquipa = DB::table('membros_equipa_startup')
                ->where('fk_startup', $startup->fk_user)
                ->get();

            $returnHtml = view('perfil_startup', compact('startup', 'rodada', 'investidoresDaStartup', 'membrosEquipa', 'myProfile'));
        } else if ($user->tipo == 'investidor') {
            $investidor = Investidores::where('fk_user', $user->id)
                ->first();
            $returnHtml = view('perfil_investidor', compact('investidor'));
        }

        return $returnHtml;
    }

    public function loadFormEditIntroStartup(Request $request)
    {

        $user = User::with('startup')
            ->where('code_user', $request->codigoStartup)
            ->first();

        $setores = Setores::get();
        $fases = Fases::get();
        $tiposNegocio = TipoBusness::get();

        $returnHtml = view('modais/forms/form_edit_intro_startup', compact('user', 'setores', 'fases', 'tiposNegocio'))->render();

        return response()->json($returnHtml);
    }

    public function loadTmpImg(Request $request)
    {
        $extensao = $request->file('img_tmp')->extension();
        $dataAtual = Carbon::now()->format('mYdhsm');
        $img = 'tmp_' . $request->code . '_' . $dataAtual . '.' . $extensao;

        $filesForDelete = public_path() . '/storage/armazenamento/startups/img/tmp/*' . $request->code . '*';
        chmod(public_path() . '/storage/armazenamento/startups/img/tmp/', 0777); // Caso o sistema seja hospedado num linux server
        array_map("unlink", glob($filesForDelete));

        $uploadFicheiro = $request->file('img_tmp')->storeAs('armazenamento/startups/img/tmp', $img);



        return response()->json($uploadFicheiro);
    }

    public function editarIntroStartup(Request $request)
    {

        $userCode = $request->code_user;

        $startup = Startups::whereHas('user', function ($query) use ($userCode) {
            $query->where('code_user', $userCode);
        })
            ->first();

        $uploadFicheiro = $startup->logotipo;

        $pitch = "A##{$startup->nome}##está construindo##{$request->pitch_line1}##para ajudar##{$request->pitch_line2}##
        a##{$request->pitch_line3}##com##{$request->pitch_line4}";

        $dataAtual = Carbon::now()->format('mYdhsm');

        if (!empty($request->file('img_startup_edit'))) {
            $extensao = $request->file('img_startup_edit')->extension();

            $nomeArquivo = "logotipo_{$startup->fk_user}_{$dataAtual}.{$extensao}";
            $filesForDelete = public_path() . '/storage/armazenamento/startups/img/logotipo_' . $startup->fk_user . '*';
            chmod(public_path() . '/storage/armazenamento/startups/img/', 0777); // Caso o sistema seja hospedado num linux server
            array_map("unlink", glob($filesForDelete));

            $uploadFicheiro = $request->file('img_startup_edit')->storeAs('armazenamento/startups/img', $nomeArquivo);
        }






        Startups::whereHas('user', function ($query) use ($userCode) {
            $query->where('code_user', $userCode);
        })->update([
            'fk_setor_economico' => $request->setor_startup_edit,
            'fk_fase_desenvolvimento' => $request->fase_startup_edit,
            'pitch_elevator' => $pitch,
            'logotipo' => $uploadFicheiro,
            'fk_tipo_negocio' => $request->negocio_startup_edit
        ]);
    }

    public function atualizarIntroducaoStartup(Request $request)
    {
        $userCode = $request->codigoStartup;

        $startup = Startups::whereHas('user', function ($query) use ($userCode) {
            $query->where('code_user', $userCode);
        })
            ->first();

        $returnHtm = view('blocos_html/introducao_startup', compact('startup'))->render();

        return response()->json(
            [
                'returnHtm' => $returnHtm,
                'urlImg' => $startup->logotipo
            ]
        );
    }

    public function adicionarInvestidor(Request $request)
    {
        $userCode = $request->codeUser;
        $startup = Startups::whereHas('user', function ($query) use ($userCode) {
            $query->where('code_user', $userCode);
        })
            ->first();

        $tipoEntidade = $request->tipo_investidor == 1 ? 'juridica' : 'fisica';


        $values = [
            'email' => $request->email,
            'nome' => $request->nome,
            'fk_startup' => $startup->fk_user,
            'porcentagem_na_startup' => $request->porcentagem,
            'tipo_entidade' => $tipoEntidade
        ];


        if (!empty($request->sobrenome)) {
            $values['sobrenome'] = $request->sobrenome;
        }

        $investidorDaStartup = InvestidoresDaStartup::create($values);
        $tipoEntidadeToTupla = $investidorDaStartup->tipo_entidade == 1 ? 'Jurídica' : 'Física';
        $returnHtm = view('blocos_html/tupla_novo_investidor_da_startup', compact('investidorDaStartup', 'tipoEntidadeToTupla'))->render();

        return response()->json($returnHtm);
    }

    public function loadFormEditarInvestidorStartup(Request $request)
    {
        $code = $request->code;
        $investidorDaStartup = InvestidoresDaStartup::where('id', $code)
            ->first();

        $returnHtml = view('modais/forms/form_edit_investidor_startup', compact('investidorDaStartup'))->render();

        return response()->json($returnHtml);
    }

    public function editarInvestidorStartup(Request $request)
    {
        $idInvestidorDaStartup = $request->codeInvest;
        $tipoEntidade = $request->tipo_investidor == 1 ? 'juridica' : 'fisica';

        $valores = [
            'email' => $request->email,
            'nome' => $request->nome,
            'porcentagem_na_startup' => $request->porcentagem,
            'tipo_entidade' => $tipoEntidade
        ];

        if (!empty($request->sobrenome))
            $valores['sobrenome'] = $request->sobrenome;


        InvestidoresDaStartup::where('id', $idInvestidorDaStartup)
            ->update($valores);

        $investidorDaStartup = InvestidoresDaStartup::where('id', $idInvestidorDaStartup)
            ->first();

        $tipoEntidadeToTupla = $request->tipo_investidor == 1 ? 'Jurídica' : 'Física';

        $returnHtml = view('blocos_html/celulas_atualizar_investidor_da_startup_next_edit', compact('investidorDaStartup', 'tipoEntidadeToTupla'))->render();

        return response()->json([
            'html' => $returnHtml,
            'code' => $idInvestidorDaStartup
        ]);
    }


    public function eliminarInvestidorStartup(Request $request)
    {
        $idInvestidor = $request->idInvestidorDaStartup;

        InvestidoresDaStartup::where('id', $idInvestidor)
            ->delete();
    }

    public function buscarCargosExecutvo()
    {
        $cargosExecutivo = CargosExecutivo::get();
        $returnHtml = view('blocos_html/intens_cargos_executivo', compact('cargosExecutivo'))->render();

        return response()->json($returnHtml);
    }

    public function buscarCertificados(Request $request)
    {
        $palavras = $request->valorCertificadoInput;

        $certificados = CertificadosFormacao::where('nome', 'like', $palavras . '%')
            ->get();

        $returnHtml = view('blocos_html/lista_resultado_busca_certificados', compact('certificados'))->render();

        return response()->json($returnHtml);
    }

    public function buscarAreasFormacao(Request $request)
    {
        $palavras = $request->valorAreaFormacaoInput;

        $areas = AreasFormacao::where('nome', 'like', $palavras . '%')
            ->get();

        $returnHtml = view('blocos_html/lista_resultado_busca_areas_formacao', compact('areas'))->render();

        return response()->json($returnHtml);
    }

    public function loadTmpImgMembroEquipa(Request $request)
    {

        $extensao = $request->file('img_tmp')->extension();
        $dataAtual = Carbon::now()->format('mYdhsm');
        $img = 'tmp_' . $request->code . '_' . $dataAtual . '.' . $extensao;

        $filesForDelete = public_path() . '/storage/armazenamento/startups/img/tmp/membro/*' . $request->code . '*';
        chmod(public_path() . '/storage/armazenamento/startups/img/tmp/membro/', 0777); // Caso o sistema seja hospedado num linux server
        array_map("unlink", glob($filesForDelete));

        $uploadFicheiro = $request->file('img_tmp')->storeAs('armazenamento/startups/img/tmp/membro', $img);



        return response()->json($uploadFicheiro);
    }

    public function adicionarMembroEquipa(Request $request)
    {
        return response()->json($request->formacao);
    }
}
