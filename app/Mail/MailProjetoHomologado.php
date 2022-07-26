<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailProjetoHomologado extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $titulo, $idProj) {
        $this->nome = $nome;
        $this->titulo = $titulo;
        $this->idProj = $idProj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return  $this->subject('IFCITEC - Projeto Homologado')
			->view('mail.projetoHomologado', ['idProj' => $this->idProj])
			->withNome($this->nome)
			->withTitulo($this->titulo);
    }
}
