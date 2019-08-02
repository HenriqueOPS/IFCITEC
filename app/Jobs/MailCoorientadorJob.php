<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailCoorientador;
use Illuminate\Support\Facades\Auth;

class MailCoorientadorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 10;

    public $email;
    public $nome;
    public $titulo;
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         Mail::to($this->email)
         ->send(new MailCoorientador($this->nome, $this->titulo));
    }
}
