<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Projeto;
use App\Pessoa;

class MailMassa extends Mailable
{
    use Queueable, SerializesModels;

    public $conteudo;
    public $titulo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conteudo,$titulo)
    {
        $this->conteudo = $conteudo;
        $this->titulo = $titulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->titulo)
            ->view('mail.base');
    }
}
