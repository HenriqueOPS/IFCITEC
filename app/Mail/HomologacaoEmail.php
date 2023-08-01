<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HomologacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;

    public function __construct($nome)
    {
        $this->nome = $nome;
    }

    public function build()
    {
        return $this->subject('Homologação no Sistema')
                    ->view('mail.homologacao')
                    ->with([
                        'nome' => $this->nome,
                    ]);
    }
}