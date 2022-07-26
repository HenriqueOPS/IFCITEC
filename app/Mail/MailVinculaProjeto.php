<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailVinculaProjeto extends Mailable {
    use Queueable, SerializesModels;

    public $email;
    public $nome;
    public $titulo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $nome, $titulo) {
        $this->email = $email;
        $this->nome = $nome;
        $this->titulo = $titulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('IFCITEC - Projeto Vinculado')
            ->view('mail.vinculaProjeto')
            ->withNome($this->nome)
            ->withTitulo($this->titulo);
    }
}
