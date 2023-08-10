<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MailAllJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $conteudo;
    protected $email;
    protected $titulo;

    /**
     * Create a new job instance.
     *
     * @param string $conteudo
     * @param string $email
     */
    public function __construct($conteudo, $email, $titulo)
    {
        $this->conteudo = $conteudo;
        $this->email = $email;
        $this->titulo = $titulo; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new \App\Mail\MailMassa($this->conteudo, $this->titulo);
        Mail::to($this->email)->send($email);
    }
}