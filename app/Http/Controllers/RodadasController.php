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
use Illuminate\Support\Facades\Storage;
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

            $investidor =  RodadasInvestidores::where('fk_rodada', $request->id_rodada)->where('fk_investidor',Auth::user()->id)->first();
            $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->where('fk_investidor','!=',Auth::user()->id)->get();
        }else
            $investidores = RodadasInvestidores::where('fk_rodada', $request->id_rodada)->get();
        $rodada = RodadasInvestimento::where('id', $request->id_rodada)->first();
        return view('pagina_da_rodada', compact('notificacoes', 'qtdnotifications', 'qtdMessageUnview', 'investidores', 'rodada', 'investidor'))->render();
    }

    public function visualizarParaAssinarPdf(Request $request){
        $url_pdf = 'storage/armazenamento/contratos/'.$request->doc;
        return view('visualiza_pdf', compact('url_pdf'));
    }

    public function addSignature(Request $request)
    {
    
        $path = $request->input('path');
        $x = $request->input('x');
        $y = $request->input('y');
        $signatureData = $request->input('signature');
        $public_path = public_path();

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($public_path.'/storage/armazenamento/contratos/doc.pdf');
        $template = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($template);

        $signaturePath = $public_path.'/storage/armazenamento/contratos/signature.png';
        list($type, $signatureData) = explode(';', $signatureData);
        list(, $signatureData)      = explode(',', $signatureData);
        $signatureData = base64_decode($signatureData);
        file_put_contents($signaturePath, $signatureData);

        $pdf->Image($signaturePath, $x, $y, 50); // Adjust size and position as needed

        $outputPath = $public_path.'/storage/armazenamento/contratos/doc_two.pdf';
        $pdf->Output($outputPath, 'F');

        return response()->download($outputPath);
    }  
    
   
}
