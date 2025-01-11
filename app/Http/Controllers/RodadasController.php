<?php

namespace App\Http\Controllers;

use App\Investidores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications;
use Illuminate\Support\Facades\DB;
use App\Mensagens;
use App\RodadasInvestidores;
use App\RodadasInvestimento;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use App\User;
use App\Events\SendMessage;
use App\Notifications\Message;
use App\Startups;
use App\Services\RodadaService;
use App\Events\AnularRodada;
use App\Events\AbrirRodada;
use App\PermissoesVerPitch;
use App\EntradaDoModelo;
use App\SaidaDoModelo;
use App\Services\MachineLearningService;

class RodadasController extends Controller
{
    public function showPage(Request $request)
    {
        $qtdnotifications = 0;
        $presentUser = Auth::user()->id;
        $investidor = null;

        Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->update([
                'status' => 'visto'
            ]);

        $notificacoes  = Notifications::where('fk_user_distination', $presentUser)
            ->select('*', DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y %h:%m") as data'))
            ->orderBy('created_at', 'DESC')
            ->get();

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        if (Auth::user()->tipo == 'investidor') {

            $investidor =  RodadasInvestidores::where('fk_rodada', $request->id_rodada)->where('fk_investidor', Auth::user()->id)->first();
            $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->where('fk_investidor', '!=', Auth::user()->id)->get();
        } else
            $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->get();
        $rodada = RodadasInvestimento::where('id', $request->id_rodada)->first();
        return view('pagina_da_rodada', compact('notificacoes', 'qtdnotifications', 'qtdMessageUnview', 'investidores', 'rodada', 'investidor', 'presentUser'))->render();
    }



    public function cadastrarOferta(Request $request, RodadaService $rodadaService, MachineLearningService $mpl)
    {

        try {
            $entradaModelo = $rodadaService->getEntradaModelo($request);
            $saidaModelo = $mpl->predictGrowth(array_values($entradaModelo));
            $meta =  str_replace(',', '.', str_replace('.', '', $request->meta));
            $taxa = str_replace(',', '.', str_replace('.', '', $request->montante_acrescer));
            $metaComATaxa = $meta + $taxa;
            $porcentagem = str_replace(',', '.', str_replace('.', '', $request->porcentagem));
            $dataTermino = $request->termino;
            $maxInvestidores = $request->max_investidores;
            $pitchFile = $request->file('pitch_video');

            $getErros = $this->validarMetaPorcentagem($meta, $porcentagem);
            if ($getErros != null)
                return response()->json(['status' => 500, $getErros]);

            $extensaoPitch = $pitchFile->extension();
            $userId = Auth::user()->id;
            $nomePitch = "pitch_{$userId}.{$extensaoPitch}";

            $uploadFicheiro = $request->file('pitch_video')->storeAs('armazenamento/startups/pitch', $nomePitch);

            $currentRodadaSaved = RodadasInvestimento::create([
                'fk_startup' => $userId,
                'valor_objetivo' => $metaComATaxa + 0.0,
                'valor_objetivo_sem_taxa' => $meta + 0.0,
                'oferta_acoes' => $porcentagem + 0.0,
                'max_investidores' => $maxInvestidores,
                'valor_minimo_investimento' => ($metaComATaxa / $maxInvestidores),
                'data_limite' => $dataTermino,
                'estado' => 'aberta',
                'potencial_de_crescimento' => $saidaModelo->growth_potential
            ]);

            $entradaModelo['id_rodada'] = $currentRodadaSaved->id;
            EntradaDoModelo::create($entradaModelo);
            foreach ($saidaModelo->weaknesses as $index => $value) {
                SaidaDoModelo::create([
                    'id_rodada' => $currentRodadaSaved->id,
                    'variavel' => $index,
                    'valor' => $value,
                    'classificacao' => 'weaknesses'
                ]);
            }

            foreach ($saidaModelo->strengths as $index => $value) {
                SaidaDoModelo::create([
                    'id_rodada' => $currentRodadaSaved->id,
                    'variavel' => $index,
                    'valor' => $value,
                    'classificacao' => 'strengths'
                ]);
            }

            Startups::where('fk_user', $userId)
                ->update([
                    'estado_busca_invest' => 'sim',
                    'pitch_deck' => $uploadFicheiro
                ]);


            event(new AbrirRodada());

            return response()->json(['status' => 200]);
        } catch (ErrorException $e) {
            return response()->json(['status' => 500], ['message' => $e->getMessage()]);
        }
    }

    public function anularOferta(Request $request)
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

        RodadasInvestidores::where('fk_rodada', $request->rodada_id)->update([
            'status_investimento' => 2
        ]);

        PermissoesVerPitch::where('fk_startup', $idUser)
            ->update([
                'estado' => 'vencido'
            ]);


        $filesForDelete = public_path() . '/storage/armazenamento/startups/pitch/pitch_' . $idUser . '*';
        chmod(public_path() . '/storage/armazenamento/startups/pitch/', 0777); // Caso o sistema seja hospedado num linux server
        array_map("unlink", glob($filesForDelete));

        event(new AnularRodada());
    }

    public function saveContrato(Request $request)
    {
        $file = $request->file('file');
        $idInvestor = $request->idInvestor;
        $presentUser = Auth::user()->id;
        $idRodada = $request->idRodada;
        $currentDate = Carbon::now()->format('Ymdhs');


        if (empty($file))
            return response()->json(['error' => 'file verification', 'message' => 'The file not informed'], 500);
        $contract = "contract{$presentUser}{$idRodada}{$idInvestor}{$currentDate}.pdf";
        try {
            $path = $request->file('file')->storeAs('armazenamento/contratos', $contract);
            RodadasInvestidores::where([
                ['fk_rodada', $idRodada],
                ['fk_investidor', $idInvestor]
            ])
                ->update([
                    'contrato_mutou' => $path
                ]);
            $investidor = RodadasInvestidores::where('fk_rodada', $idRodada)->where('fk_investidor', $idInvestor)->first();
            $rodada = RodadasInvestimento::where('id', $idRodada)->first();
            $html = view('blocos_html/investment_situation2', compact('rodada', 'investidor', 'presentUser'))->render();
        } catch (ErrorException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json([
            'html' => $html
        ]);
    }

    public function removeContrato(Request $request)
    {
        $idInvestor = $request->idInvestor;
        $presentUser = Auth::user()->id;
        $idRodada = $request->rodadaId;

        $fileToRemove = public_path() . "\storage\armazenamento\contratos\contract{$presentUser}{$idRodada}{$idInvestor}*.pdf";

        try {

            chmod(public_path() . '/storage/armazenamento/contratos', 0777);
            array_map("unlink", glob($fileToRemove));
            RodadasInvestidores::where([
                ['fk_rodada', $idRodada],
                ['fk_investidor', $idInvestor]
            ])
                ->update([
                    'contrato_mutou' => NULL,
                    'status_contrato_investidor' => 1,
                    'status_contrato_startup' => 1
                ]);
            $investidor = RodadasInvestidores::where('fk_rodada', $idRodada)->first();
            $rodada = RodadasInvestimento::where('id', $idRodada)->first();
            $html = view('blocos_html/investment_situation2', compact('rodada', 'investidor', 'presentUser'))->render();
        } catch (ErrorException $e) {
            return response()->json(['error' => 'About remove Contract', 'message' => $e->getMessage()], 500);
        }
        return response()->json([
            'html' => $html
        ]);
    }

    public function updateIinvestSituation1(Request $request)
    {
        $idRodada = $request->rodadaId;
        $presentUser = Auth::user()->id;
        $investidor =  RodadasInvestidores::where('fk_rodada', $idRodada)->where('fk_investidor', Auth::user()->id)->first();
        $rodada = RodadasInvestimento::where('id', $idRodada)->first();

        $html = view('blocos_html/investment_situation1', compact('rodada', 'investidor', 'presentUser'))->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function updateIinvestSituation2(Request $request)
    {
        try {
            $idIvestidor = $request->idIvestidor;
            $rodadaId = $request->rodadaId;
            $presentUser = Auth::user()->id;
            $investidor = RodadasInvestidores::where('fk_rodada', $rodadaId)->where('fk_investidor', $idIvestidor)->first();
            $rodada = RodadasInvestimento::where('id', $rodadaId)->first();

            $html = view('blocos_html/investment_situation2', compact('rodada', 'investidor', 'presentUser'))->render();
        } catch (ErrorException $e) {
            return response()->json([
                'message' => $e,
                'teste' => 'guito'
            ], 500);
        }
        return response()->json([
            'html' => $html
        ]);
    }

    public function viewDoc(Request $request)
    {
        $idRodada = $request->rodada;
        $other = $request->other;
        $investidor = null;
        $startup = null;

        $qtdnotifications = 0;
        $presentUser = Auth::user()->id;

        Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->update([
                'status' => 'visto'
            ]);

        $notificacoes  = Notifications::where('fk_user_distination', $presentUser)
            ->select('*', DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y %h:%m") as data'))
            ->orderBy('created_at', 'DESC')
            ->get();

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        if (Auth::user()->tipo == "startup") {
            $investidor = $other;
            $startup = Auth::user()->id;
        } else if (Auth::user()->tipo == "investidor") {
            $startup = $other;
            $investidor = Auth::user()->id;
        }

        $rodadaInvestimento = RodadasInvestidores::where([
            ['fk_rodada', $idRodada],
            ['fk_investidor', $investidor]
        ])->first();

        $urlDoc = "storage/" . $rodadaInvestimento->contrato_mutou;
        return view('pdf_visualizer', compact('urlDoc', 'notificacoes', 'qtdnotifications', 'qtdMessageUnview'));
    }

    public function signContract()
    {
        $qtdnotifications = 0;
        $presentUser = Auth::user()->id;
        $investidor = null;

        Notifications::where('fk_user_distination', $presentUser)
            ->where('status', 'nao_visto')
            ->update([
                'status' => 'visto'
            ]);

        $notificacoes  = Notifications::where('fk_user_distination', $presentUser)
            ->select('*', DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y %h:%m") as data'))
            ->orderBy('created_at', 'DESC')
            ->get();

        $messages = Mensagens::where([

            ['fk_destinatario', $presentUser],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);
        return view('pdfjs', compact('notificacoes', 'qtdnotifications', 'qtdMessageUnview'));
    }

    public function visualizarParaAssinarPdf(Request $request)
    {
        // dd("O que está a acontecer???");
        $url_pdf = 'storage/armazenamento/contratos/contract6602202408241028.pdf';
        return view('visualiza_pdf', compact('url_pdf'));
    }

    public function addSignature(Request $request)
    {
        $pathDoc = $request->input('path_doc');
        $x = $request->input('point_x');
        $y = $request->input('point_y');
        $pageToSign =  $request->input('page_sign');

        $mmX = ($x * 210) / 714; // conversão de px para milimetro para resolucao do meu pc. 714px = 210mm
        $mmY = (($y * 210) / 714) - 13; //particularidade:devo fazer compensacao para o conto inferior esquerdo da assinatura começar a ser desenhada no ponto clicado, senão começaria pelo canto superior esquerdo

        $signatureData = $request->input('signature');
        $public_path = public_path();
        $currentUser = Auth::user()->id;
        $currentDate = Carbon::now()->format('Ymdhs');
        $pathContractSplited = explode('.', $pathDoc);
        $newContractPath =  $pathContractSplited[0] . '3.pdf';
        $rodadaInvestidor = RodadasInvestidores::where('contrato_mutou', $pathDoc)->first();
        $rodadaInvestidor->update([
            'contrato_mutou' => $newContractPath
        ]);
        $signaturePath = null;
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($public_path . '/storage/' . $pathDoc);
        for ($i = 1; $i <= $pageCount; $i++) {
            $template = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($template);
            if ($i == $pageToSign) {
                $signName = 'signature' . $currentUser . "_" . $currentDate . ".png";
                $signaturePath = $public_path . '/storage/armazenamento/contratos/' . $signName;
                list($type, $signatureData) = explode(';', $signatureData);
                list(, $signatureData)      = explode(',', $signatureData);
                $signatureData = base64_decode($signatureData);
                file_put_contents($signaturePath, $signatureData);
                $pdf->Image($signaturePath, $mmX, $mmY, 50);
            }
        }
        $outputPath = $public_path . '/storage/' . $newContractPath;
        $pdf->Output($outputPath, 'F');

        if ($rodadaInvestidor->contrato_mutou_original != $pathDoc)
            Storage::disk('public')->delete($pathDoc);
        Storage::disk('public')->delete('/armazenamento/contratos/' . $signName);


        return response()->json([
            'new_path_doc' => $newContractPath
        ]);
    }

    public function confirmarAssinatura(Request $request)
    {
        $currentUser = Auth::user();
        $pathDoc = $request->pathDoc;
        if ($currentUser->tipo == 'startup') {
            RodadasInvestidores::where('contrato_mutou', $pathDoc)
                ->update([
                    'status_contrato_startup' => 2
                ]);
        } else if ($currentUser->tipo == 'investidor') {
            RodadasInvestidores::where('contrato_mutou', $pathDoc)
                ->update([
                    'status_contrato_investidor' => 3
                ]);
        }
        return response([
            'tipo' => $currentUser->tipo
        ], 200);
    }

    public function discordarContrato(Request $request)
    {
        $rodadaId = $request->rodadaId;
        $mensagem = $request->message;
        $remetente = Auth::user()->id;
        $destinatario = RodadasInvestimento::where('id', $rodadaId)->first()->fk_startup;
        $userDestinatario = User::where('id', $destinatario)->first();

        $mensagemEnviada = Mensagens::create([
            'fk_remetente' => $remetente,
            'fk_destinatario' => $destinatario,
            'conteudo' => $mensagem
        ]);

        RodadasInvestidores::where('fk_rodada', $rodadaId)
            ->where('fk_investidor', $remetente)
            ->update([
                'status_contrato_investidor' => 2
            ]);
        $messages = Mensagens::where([

            ['fk_destinatario', $destinatario],
            ['vista', 'nao']
        ])
            ->get();

        $qtdMessageUnview = (int) count($messages);

        event(new SendMessage($destinatario, $mensagemEnviada->id));

        $userDestinatario->notify(new Message($qtdMessageUnview));

        return response(200);
    }
}
