<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAutor;
use App\Mail\MailBase;
use App\Mensagem;

class MailBaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 10;

    public $email;
    public $conteudo;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $nomeEmail, $data = [])
    {
        $conteudo = Mensagem::fetchMessageContent($nomeEmail, 'email');
        foreach ($data as $key => $var) {
            $conteudo = preg_replace('/\$' . $key . '/', $var, $conteudo);
        }

        $this->email = $email;
        $this->conteudo = $conteudo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new MailBase($this->conteudo));
    }
}
