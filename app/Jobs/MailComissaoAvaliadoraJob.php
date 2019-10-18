<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailComissao;
use Illuminate\Support\Facades\Auth;

class MailComissaoAvaliadoraJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 10;

    public $nome;
	public $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($nome, $email) {
        $this->nome = $nome;
		$this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         Mail::to($this->email)
         ->send(new MailComissao($this->nome));
    }
}
