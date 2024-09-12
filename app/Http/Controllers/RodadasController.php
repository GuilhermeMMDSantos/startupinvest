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
use Laravel\Tinker\TinkerCaster;
use setasign\Fpdi\Fpdi;


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
            $investidor = RodadasInvestidores::where('fk_rodada', $idRodada)->first();
            $rodada = RodadasInvestimento::where('id', $idRodada)->first();
            $html = view('blocos_html/investment_situation', compact('rodada', 'investidor', 'presentUser'))->render();
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
                    'contrato_mutou' => NULL
                ]);
            $investidor = RodadasInvestidores::where('fk_rodada', $idRodada)->first();
            $rodada = RodadasInvestimento::where('id', $idRodada)->first();
            $html = view('blocos_html/investment_situation', compact('rodada', 'investidor', 'presentUser'))->render();
        } catch (ErrorException $e) {
            return response()->json(['error' => 'About remove Contract', 'message' => $e->getMessage()], 500);
        }
        return response()->json([
            'html' => $html
        ]);
    }

    public function updateIinvestSituation(Request $request)
    {
        $idRodada = $request->rodadaId;
        $investidor =  RodadasInvestidores::where('fk_rodada', $idRodada)->where('fk_investidor', Auth::user()->id)->first();
        $rodada = RodadasInvestimento::where('id', $idRodada)->first();

        $html = view('blocos_html/investment_situation', compact('rodada', 'investidor'))->render();

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

        $mmX = $x * 0.2646;
        $mmY = $y * 0.2646;

        $signatureData = $request->input('signature');
        $public_path = public_path();
        $currentUser = Auth::user()->id;
        $currentDate = Carbon::now()->format('Ymdhs');
        $pathContractSplited = explode('.',$pathDoc);
        $newContractPath =  $pathContractSplited[0].'3.pdf';
        RodadasInvestidores::where('contrato_mutou', $pathDoc)
        ->update([
            'contrato_mutou' => $newContractPath
        ]);

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($public_path . '/storage/' . $pathDoc);
        $template = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($template);
        $signName = 'signature' . $currentUser . "_" . $currentDate . ".png";
        $signaturePath = $public_path . '/storage/armazenamento/contratos/' . $signName;
        list($type, $signatureData) = explode(';', $signatureData);
        list(, $signatureData)      = explode(',', $signatureData);
        $signatureData = base64_decode($signatureData);
        file_put_contents($signaturePath, $signatureData);

        $pdf->Image($signaturePath, $mmX, $mmY, 50);

        $outputPath = $public_path . '/storage/'.$newContractPath;
        $pdf->Output($outputPath, 'F');
        Storage::disk('public')->delete($pathDoc);
       // return response()->download($outputPath);

       return response()->json([
        'new_path_doc' => $newContractPath 
       ]);
    }
}
