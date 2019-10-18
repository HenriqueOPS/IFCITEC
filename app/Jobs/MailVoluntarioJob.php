<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailVoluntario;
use Illuminate\Support\Facades\Auth;

class MailVoluntarioJob implements ShouldQueue
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $nome) {
		$this->email = $email;
		$this->nome = $nome;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->send(new MailVoluntario($this->nome));
    }
}

