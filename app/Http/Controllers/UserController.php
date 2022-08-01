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
use App\ExperienciaInvestidor;
use App\ExperienciaMembroEquipa;
use App\FormacaoInvestidor;
use App\MembrosEquipaStartup;
use App\FormacaoMembroEquipa;
use App\FuncoesExperiencia;
use App\InstituicaoExperiencia;
use App\MembrosEquipaCargosExecutivos;
use App\PermissoesVerPitch;
use App\Notifications;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use App\Events\FirstEventPrivateChannel;

class UserController extends Controller
{

    public function loadStartups(Request $request)
    {

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
            ->where('estado_busca_invest', 'sim')
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
            ->where('estado_busca_invest', 'sim')
            ->get();

        $returnHtml = view('carregamentos.startup_cards', compact('startupsCards'))->render();
        return response()->json($returnHtml);
    }

    public function showPerfil($codeUser)
    {

        $user = User::where('code_user', $codeUser)->first();

        $code = Auth::user()->id;

        $myProfile = ($user->id == Auth::user()->id);

        $notifications = Notifications::where('fk_user_distination', Auth::user()->id)
            ->where('status', 'nao_visto')
            ->get();

        $qtdnotifications = (int)count($notifications);

        if ($user->tipo == 'startup') {

            $startup =  Startups::with(['setor', 'fase', 'tipobusnessfunc', 'user'])
                ->where('fk_user', $user->id)
                ->first();

            $rodada = RodadasInvestimento::with(['investidores', 'finalidadesInvestimento'])
                ->select('*', DB::raw('TIMESTAMPDIFF(DAY,NOW(),data_limite) AS tempo_restante'))
                ->where('fk_startup', $startup->fk_user)
                ->where('estado', 'aberta')
                ->first();



            $membrosEquipa = MembrosEquipaStartup::with(['cargosExecutivos', 'formacoes' => function ($query) {
                $query->with(['areafuncao', 'certificado'])
                    ->select(
                        '*',
                        DB::raw('DATE_FORMAT(data_inicio, "%Y-%m") AS dataInicioFormatada'),
                        DB::raw('DATE_FORMAT(data_fim, "%Y-%m") AS dataFimFormatada')
                    )
                    ->get();
            }, 'experiencias' => function ($query2) {
                $query2->with(['funcao', 'instituicao'])
                    ->select(
                        '*',
                        DB::raw('DATE_FORMAT(data_inicio, "%Y-%m") AS dataInicioFormatada'),
                        DB::raw('DATE_FORMAT(data_fim, "%Y-%m") AS dataFimFormatada')
                    )
                    ->get();
            }])

                ->where('fk_startup', $startup->fk_user)
                ->get();

            $codigoStartup = $codeUser;

            $returnHtml = view('perfil_startup', compact('code', 'startup', 'qtdnotifications', 'rodada', 'membrosEquipa', 'myProfile', 'codigoStartup'));
        } else if ($user->tipo == 'investidor') {

            $investidor = Investidores::with(['formacoes', 'experiencias'])
                ->where('fk_user', $user->id)
                ->first();
            $codigoInvestidor = $codeUser;
            $returnHtml = view('perfil_investidor', compact('code', 'investidor', 'qtdnotifications', 'myProfile', 'codeUser', 'codigoInvestidor'));
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

    public function loadIntroducaoStartup(Request $request)
    {
        $userCode = $request->codigoStartup;
        $tipoUser = Auth::user()->tipo;

        $startup = Startups::whereHas('user', function ($query) use ($userCode) {
            $query->where('code_user', $userCode);
        })
            ->first();


        $alreadySendRequestForSeePitch =  false;

        $this->verificarValidadePermissoesPitch($startup->fk_user, Auth::user()->id);


        $permissoesVerPitch = PermissoesVerPitch::where('fk_startup', $startup->fk_user)
            ->where('fk_investidor', Auth::user()->id)
            ->whereIn('estado', ['espera', 'ativo'])
            ->first();



        if (!empty($permissoesVerPitch))
            $alreadySendRequestForSeePitch = true;

        $myprofile = $startup->fk_user == Auth::user()->id;



        $html = view('blocos_html/introducao_startup', compact('startup', 'myprofile', 'tipoUser', 'alreadySendRequestForSeePitch'))->render();

        return response()->json(
            [
                'html' => $html
            ]
        );
    }

    public function loadOferta(Request $request)
    {


        $codeUser = $request->codeStartup;
        $havePermissionToWatchPitch = false;

        $startup = Startups::whereHas('user', function ($query) use ($codeUser) {
            $query->where('code_user', $codeUser);
        })->first();

        $myprofile = $startup->fk_user == Auth::user()->id;

        $rodada = RodadasInvestimento::with(['investidores', 'finalidadesInvestimento'])
            ->select('*', DB::raw('TIMESTAMPDIFF(DAY,NOW(),data_limite) AS tempo_restante'))
            ->where('fk_startup', $startup->fk_user)
            ->where('estado', 'aberta')
            ->first();



        if (Auth::user()->tipo == 'investidor') {
            $permissao = PermissoesVerPitch::select('estado', DB::raw('TIMESTAMPDIFF(DAY,NOW(),data_permissao) AS tempo_restante'))
                ->where('fk_startup', $startup->fk_user)
                ->where('fk_investidor', Auth::user()->id)
                ->where('estado', 'ativo')
                ->first();

            if (!empty($permissao) && $permissao->tempo_restante > 1) {
                $permissao->update([
                    'estado' => 'vencido'
                ]);
            } else if (!empty($permissao) && $permissao->tempo_restante < 1)
                $havePermissionToWatchPitch = true;
        }



        $returnHtml = view('blocos_html/content_oferta', compact('rodada', 'startup', 'havePermissionToWatchPitch', 'myprofile'))->render();

        return response()->json([
            'html' =>    $returnHtml
        ]);
    }

    public function loadInvestorsTable(Request $request)
    {

        $isMyProfile = $request->ismyprofile == 'true' ? true : false;
        $codeUser = $request->codigoStartup;
        $idUser = User::where('code_user', $codeUser)->first()->id;

        $investidoresDaStartup = DB::table('investidores_da_startup')
            ->where('fk_startup', $idUser)

            ->simplePaginate(3);

        $html = view('blocos_html/table_investors_startup', compact('investidoresDaStartup', 'isMyProfile'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function adicionarInvestidor(Request $request)
    {
        $userCode = $request->codeUser;
        $startup = Startups::whereHas('user', function ($query) use ($userCode) {
            $query->where('code_user', $userCode);
        })
            ->first();

        $tipoEntidade = $request->tipo_investidor == 1 ? 'Física' : 'Jurídica';


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
        $tipoEntidade = $request->tipo_investidor == 1 ? 'Física' : 'Jurídica';

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
        $idCargosJaAtribuidos = [];
        $startup = Startups::with(['membrosEquipa' => function ($query) {
            $query->with('cargosExecutivos')
                ->get();
        }])
            ->where('fk_user', Auth::user()->id)
            ->first();

        foreach ($startup->membrosEquipa as $membro) {
            foreach ($membro->cargosExecutivos as $cargo) {
                if (!in_array($cargo->id, $idCargosJaAtribuidos))
                    array_push($idCargosJaAtribuidos, $cargo->id);
            }
        }


        $returnHtml = view('blocos_html/intens_cargos_executivo', compact('cargosExecutivo', 'idCargosJaAtribuidos'))->render();

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

    public function buscarFuncaoExperiencia(Request $request)
    {
        $palavras = $request->wordsSearch;


        $funcoes = FuncoesExperiencia::where('nome', 'like', $palavras . '%')
            ->where('outro', 'no')
            ->get();

        $qtdFuncoes = count($funcoes);
        $returnHtml = view('blocos_html/lista_resultado_busca_funcoes_experiencia', compact('funcoes'))->render();

        return response()->json([
            'html' => $returnHtml,
            'qtd' => $qtdFuncoes
        ]);
    }

    public function buscarIntituicaoExperiencia(Request $request)
    {
        $palavras = $request->wordsSearch;

        $instituicoes = InstituicaoExperiencia::where('nome', 'like', $palavras . '%')
            ->where('outro', 'no')
            ->get();

        $qtdInstituicoes = count($instituicoes);
        $returnHtml = view('blocos_html/lista_resultado_busca_instituicoes_experiencia', compact('instituicoes'))->render();

        return response()->json([
            'html' => $returnHtml,
            'qtd' => $qtdInstituicoes
        ]);
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
        $haveNewImage = $request->haveImg;
        $nome = $request->nome;
        $sobrenome = $request->sobrenome;
        $cargosExecutivos = strlen($request->cargos) > 1 ? explode('|', $request->cargos) : array();
        $formacoes = empty($request->formacao) ? array() : explode(',', $request->formacao);
        $experiencias = empty($request->experiencia) ? array() : explode(',', $request->experiencia);




        $membro = MembrosEquipaStartup::create([
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'fk_startup' => Auth::user()->id
        ]);

        $uploadFicheiro = 'armazenamento/startups/img/membros/img_standard_membro_equipa.png';

        if ($haveNewImage == 'true') {
            $extensao = $request->file('imagem')->extension();
            $nomeArquivo = "imagem_membro{$membro->id}.{$extensao}";
            $filesForDelete = public_path() . '/storage/armazenamento/startups/img/membros/imagem_membro' . $membro->id . '*';
            chmod(public_path() . '/storage/armazenamento/startups/img/membros/', 0777); // Caso o sistema seja hospedado num linux server
            array_map("unlink", glob($filesForDelete));

            $uploadFicheiro = $request->file('imagem')->storeAs('armazenamento/startups/img/membros', $nomeArquivo);
        }

        MembrosEquipaStartup::where('id', $membro->id)
            ->update([
                'img' => $uploadFicheiro
            ]);


        foreach ($formacoes as $formacao) {

            $formacaoSplit = explode('|', $formacao);
            $dataInicioFormacao = $formacaoSplit[2] . '-01';
            $dataFimFormacao = $formacaoSplit[3] . '-01';

            FormacaoMembroEquipa::create([
                'fk_membro_equipa' => $membro->id,
                'fk_area_formacao' => $formacaoSplit[1],
                'fk_certificado_formacao' => $formacaoSplit[0],
                'data_inicio' => $dataInicioFormacao,
                'data_fim' => $dataFimFormacao
            ]);
        }

        foreach ($experiencias as $experiencia) {
            $experienciaSplit = explode('|', $experiencia);
            $idFuncao = null;
            $idInstituicao = null;

            if ($experienciaSplit[1] == 0) {
                $funcao = FuncoesExperiencia::create([
                    'nome' => $experienciaSplit[0],
                    'outro' => 'yes'
                ]);

                $idFuncao =  $funcao->id;
            } else
                $idFuncao = $experienciaSplit[1];

            if ($experienciaSplit[3] == 0) {

                $instituicao = InstituicaoExperiencia::create([
                    'nome' => $experienciaSplit[2],
                    'outro' => 'yes'
                ]);

                $idInstituicao = $instituicao->id;
            } else
                $idInstituicao = $experienciaSplit[3];

            $dataInicio = $experienciaSplit[4] . '-01';
            $dataFimExperiencia = $experienciaSplit[5] == "momento" ? NULL : $experienciaSplit[5] . '-01';

            ExperienciaMembroEquipa::create([
                'fk_membro_equipa' => $membro->id,
                'fk_funcao' => $idFuncao,
                'fk_instituicao' => $idInstituicao,
                'data_inicio' => $dataInicio,
                'data_fim' => $dataFimExperiencia
            ]);
        }

        foreach ($cargosExecutivos as $cargo) {
            if (strlen($cargo) > 0) {
                MembrosEquipaCargosExecutivos::create(['fk_cargo_executivo' => $cargo, 'fk_membro_equipa' => $membro->id]);
            }
        }


        $membrosEquipa = MembrosEquipaStartup::with(['cargosExecutivos', 'formacoes' => function ($query) {
            $query->with(['areafuncao', 'certificado'])
                ->select(
                    '*',
                    DB::raw('DATE_FORMAT(data_inicio, "%Y-%m") AS dataInicioFormatada'),
                    DB::raw('DATE_FORMAT(data_fim, "%Y-%m") AS dataFimFormatada')
                )
                ->get();
        }, 'experiencias' => function ($query2) {
            $query2->with(['funcao', 'instituicao'])
                ->select(
                    '*',
                    DB::raw('DATE_FORMAT(data_inicio, "%Y-%m") AS dataInicioFormatada'),
                    DB::raw('DATE_FORMAT(data_fim, "%Y-%m") AS dataFimFormatada')
                )
                ->get();
        }])

            ->where('fk_startup', Auth::user()->id)
            ->get();


        $html = view('blocos_html/content_membros_equipa', compact('membrosEquipa'))->render();

        return response()->json($html);
    }

    public function cadastrarOferta(Request $request)
    {
        $meta = $request->meta;
        $porcentagem = $request->porcentagem;
        $dataTermino = $request->termino;

        $extensaoPitch = $request->file('pitch_video')->extension();
        $userId = Auth::user()->id;
        $nomePitch = "pitch_{$userId}.{$extensaoPitch}";

        $filesForDelete = public_path() . '/storage/armazenamento/startups/pitch/pitch_' . $userId . '*';
        chmod(public_path() . '/storage/armazenamento/startups/pitch/', 0777); // Caso o sistema seja hospedado num linux server
        array_map("unlink", glob($filesForDelete));

        $uploadFicheiro = $request->file('pitch_video')->storeAs('armazenamento/startups/pitch', $nomePitch);

        $rodadaInvestimento = RodadasInvestimento::create([
            'fk_startup' => $userId,
            'valor_objetivo' => $meta,
            'oferta' => $porcentagem,
            'data_limite' => $dataTermino,
            'estado' => 'aberta'
        ]);;



        Startups::where('fk_user', $userId)
            ->update([
                'estado_busca_invest' => 'sim',
                'pitch_deck' => $uploadFicheiro
            ]);
    }

    public function anularOferta()
    {
        $idUser = Auth::user()->id;

        Startups::where('fk_user', $idUser)
            ->update([
                'estado_busca_invest' => 'nao'
            ]);

        RodadasInvestimento::where('fk_startup', $idUser)
            ->where('estado', 'aberta')
            ->update([
                'estado' => 'anulada'
            ]);

        PermissoesVerPitch::where('fk_startup', $idUser)
            ->update([
                'estado' => 'vencido'
            ]);
    }

    public function getIntroducaoInvestidor(Request $request)
    {
        $codeUser = $request->codeUser;


        $investidor = Investidores::whereHas('user', function ($query) use ($codeUser) {
            $query->where('code_user', $codeUser);
        })
            ->first();

        $myProfile = Auth::user()->id == $investidor->fk_user;
        $permissoesVerPitch = null;

        if (Auth::user()->tipo == "startup") {

            $this->verificarValidadePermissoesPitch(Auth::user()->id, $investidor->fk_user);
            $permissoesVerPitch = PermissoesVerPitch::where('fk_startup', Auth::user()->id)
                ->where('fk_investidor', $investidor->fk_user)
                ->whereIn('estado', ['espera', 'ativo'])
                ->first();
        }



        $html = view('blocos_html/introducao_investidor', compact('investidor', 'permissoesVerPitch'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function getExperienciasDoInvestidor(Request $request)
    {
        $codeUser = $request->codeUser;
        $user = User::where('code_user', $codeUser)->first();
        $myProfile = Auth::user()->id == $user->id ? true : false;

        $experiencias = ExperienciaInvestidor::select(
            '*',
            DB::raw('DATE_FORMAT(data_inicio, "%Y-%m") AS dataInicioFormatada'),
            DB::raw('DATE_FORMAT(data_fim, "%Y-%m") AS dataFimFormatada')
        )
            ->where('fk_investidor', $user->id)->get();
        $html = view('blocos_html/lista_experiencia_investidor', compact('experiencias', 'myProfile'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function cadastrarExperienciasDoInvestidor(Request $request)
    {
        $idFuncao = $request->id_experiencia_funcao;
        $idInstituicao = $request->id_experiencia_instituicao;
        if ($idFuncao == 0) {
            $funcao = FuncoesExperiencia::create([
                'nome' => $request->experiencia_funcao_input,
                'outro' => 'yes'
            ]);

            $idFuncao = $funcao->id;
        }

        if ($idInstituicao == 0) {
            $instituicao = InstituicaoExperiencia::create([
                'nome' => $request->experiencia_instituicao_input,
                'outro' => 'yes'
            ]);

            $idInstituicao =  $instituicao->id;
        }

        $dataInicio = $request->experiencia_mes_ano_inicio . '-01';
        $dataFim = empty($request->experiencia_mes_ano_fim) ? NULL : $request->experiencia_mes_ano_fim . '-01';

        ExperienciaInvestidor::create([
            'fk_investidor' => Auth::user()->id,
            'fk_funcao' => $idFuncao,
            'fk_instituicao' => $idInstituicao,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim
        ]);
    }

    public function getFormacoesDoInvestidor(Request $request)
    {

        $codeUser = $request->codeUser;
        $user = User::where('code_user', $codeUser)->first();
        $myProfile = Auth::user()->id == $user->id ? true : false;
        $formacoes = FormacaoInvestidor::select(
            '*',
            DB::raw('DATE_FORMAT(data_inicio, "%Y-%m") AS dataInicioFormatada'),
            DB::raw('DATE_FORMAT(data_fim, "%Y-%m") AS dataFimFormatada')
        )
            ->where('fk_investidor', $user->id)
            ->get();

        $html = view('blocos_html/lista_formacao_investidor', compact('formacoes', 'myProfile'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function cadastrarFormacaoInvestidor(Request $request)
    {
        $idCartificado = $request->id_formacao_certificado;
        $idAreaFormacao =  $request->id_formacao_area_formacao;
        $dataInicio =  $request->formacao_mes_ano_inicio . '-01';
        $dataFim =  $request->formacao_mes_ano_fim . '-01';

        FormacaoInvestidor::create([
            'fk_investidor' => Auth::user()->id,
            'fk_area_formacao' => $idAreaFormacao,
            'fk_certificado_formacao' => $idCartificado,
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim
        ]);
    }

    public function solicitarPitch(Request $request)
    {
        $codeUser = $request->codeStartup;


        $startup = Startups::whereHas('user', function ($query) use ($codeUser) {
            $query->where('code_user', $codeUser);
        })->first();

        $investidor = Investidores::where('fk_user', Auth::user()->id)->first();

        $nomeCompletoInvestidor = $investidor->nome;

        if ($investidor->sobrenome != null)
            $nomeCompletoInvestidor  = $nomeCompletoInvestidor . ' ' . $investidor->sobrenome;

        $message = "Investidor {$nomeCompletoInvestidor} deseja assistir vosso pitch!";

        Notifications::create([
            'message' => $message,
            'fk_user_distination' => $startup->fk_user,
            'fk_user_origin' => $investidor->fk_user,
            'status' => 'nao_visto',
            'tipo' => 'ver_pitch'
        ]);

        PermissoesVerPitch::create([
            'fk_startup' => $startup->fk_user,
            'fk_investidor' => $investidor->fk_user,
            'estado' => 'espera'
        ]);

        $notificacoes = Notifications::where('fk_user_distination', $startup->fk_user)
            ->where('status', 'nao_visto')
            ->get();

        $qtdNotification = (int)count($notificacoes);

        $user = User::where('code_user', $codeUser)->first();
        // $user->notify(new \App\Notifications\FirstNotification($qtdNotification));

        event(new FirstEventPrivateChannel($user->id, $qtdNotification));
    }

    public function setPermissaoVerPitch(Request $request)
    {
        $codeUser = $request->codeUser;

        $investidor = Investidores::whereHas('user', function ($query) use ($codeUser) {
            $query->where('code_user', $codeUser);
        })
            ->first();



        $startup = Startups::where('fk_user', Auth::user()->id)
            ->first();

        $user = User::where('code_user', $codeUser)->first();

        $message = "A startup {$startup->nome} aceitou sua solicitação para ver o pitch.";

        Notifications::create([
            'message' => $message,
            'fk_user_distination' => $investidor->fk_user,
            'fk_user_origin' => $startup->fk_user,
            'status' => 'nao_visto',
            'tipo' => 'ver_pitch'
        ]);

        PermissoesVerPitch::where([
            ['fk_startup', $startup->fk_user],
            ['fk_investidor', $investidor->fk_user],
            ['estado', 'espera']
        ])
            ->update([
                'estado' => 'ativo'
            ]);

        $notificacoes = Notifications::where('fk_user_distination', $investidor->fk_user)
            ->where('status', 'nao_visto')
            ->get();

        $qtdNotification = (int)count($notificacoes);

        $user->notify(new \App\Notifications\FirstNotification($qtdNotification));
    }

    public function verificarValidadePermissoesPitch($idStartup, $idInvestidor)
    {

        $permissoesEmEspera = PermissoesVerPitch::select(
            DB::raw("TIMESTAMPDIFF(DAY,NOW(),created_at) AS tempo_espera"),
            DB::raw("TIMESTAMPDIFF(DAY,NOW(),data_permissao) AS tempo_ativo")
        )
            ->where('fk_startup', $idStartup)
            ->where('fk_investidor', $idInvestidor)
            ->whereIn('estado', ['espera', 'ativo'])
            ->get();


        foreach ($permissoesEmEspera as $permissao) {
            if ($permissao->tempo_espera > 2 && $permissao->estado == 'espera') {
                PermissoesVerPitch::where('id', $permissao->id)
                    ->update([
                        'estado' => 'ignorado'
                    ]);
            } else if ($permissao->tempo_ativo > 2 && $permissao->estado == 'ativo') {
                PermissoesVerPitch::where('id', $permissao->id)
                    ->update([
                        'estado' => 'vencido'
                    ]);
            }
        }
    }
}
