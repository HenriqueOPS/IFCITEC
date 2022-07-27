<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailProjetoNaoHomologado extends Mailable {
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($nome, $titulo) {
		$this->nome = $nome;
		$this->titulo = $titulo;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(){
		return  $this->subject('IFCITEC - Projeto Não Homologado')
			->view('mail.projetoNaoHomologado')
			->withNome($this->nome)
			->withTitulo($this->titulo);
	}
}
