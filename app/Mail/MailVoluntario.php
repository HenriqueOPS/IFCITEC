<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailVoluntario extends Mailable
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $nome;
    public $titulo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $nome, $titulo)
    {
        $this->email = $email;
        $this->nome = $nome;
        $this->titulo = $titulo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('IFCITEC')->view('mail.mailVoluntario');
    }
}
