<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSenha extends Mailable {
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $token;
    public $details;

    public function __construct($information) {
        $this->details = $information;
        $this->token = $information['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('IFCITEC - Redefinir Senha')->view('mail.senha');
    }
}
