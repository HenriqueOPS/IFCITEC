<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailComissao extends Mailable {
    use Queueable, SerializesModels;

    public $nome;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome) {
        $this->nome = $nome;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('IFCITEC')
			->view('mail.comissaoAvaliadora')
			->withNome($this->nome);
    }
}
