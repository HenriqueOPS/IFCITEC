<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Projeto;
use App\Pessoa;

class MailBase extends Mailable
{
    use Queueable, SerializesModels;

    public $conteudo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($conteudo)
    {
        $this->conteudo = $conteudo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('IFCITEC - Mail base')
            ->view('mail.base');
    }
}
