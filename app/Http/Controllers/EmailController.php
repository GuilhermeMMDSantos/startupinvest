<?php

namespace App\Http\Controllers;

use App\Mail\EmailCadastro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send()
    {
        $sended = Mail::to('guiframart@hotmail.com','Guilherme Dos Santos')->send(new EmailCadastro);
    }
}
