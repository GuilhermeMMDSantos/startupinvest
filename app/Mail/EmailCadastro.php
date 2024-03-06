<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailCadastro extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $senhaUser;
    private $nomeUser;
    private $statusCadastro;

    public function __construct($senha,$nome,$status)
    {
        $this->senhaUser = $senha;
        $this->nomeUser = $nome;
        $this->statusCadastro = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $senha = $this->senhaUser;
        $nome = $this->nomeUser;
        $status = $this->statusCadastro;

        if ($status == 0)
            return $this->subject('Cadastro na StartupInvest')->view('emails.email_regeitado');

        return $this->subject('Cadastro na StartupInvest')->view('emails.email_aceite', compact('senha', 'nome'));
    }
}
