<?php

namespace App\Own;

use App\Mail\EmailCadastro;
use Illuminate\Support\Facades\Mail;

class Email
{

    public static function send($toEmail,$toName,$senha,$status)
    {
        $sended = Mail::to($toEmail,$toName)->send(new EmailCadastro($senha,$toName,$status));
    }

    
}
