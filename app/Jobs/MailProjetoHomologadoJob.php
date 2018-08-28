<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailProjetoHomologado;
use Illuminate\Support\Facades\Auth;

class MailProjetoHomologadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $nome;
    public $titulo;
    public $idProj;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $nome, $titulo, $idProj)
    {
        $this->email = $email;
        $this->nome = $nome;
        $this->titulo = $titulo;
        $this->idProj = $idProj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         Mail::to($this->email)
         ->send(new MailProjetoHomologado($this->nome, $this->titulo, $this->idProj));
    }
}
