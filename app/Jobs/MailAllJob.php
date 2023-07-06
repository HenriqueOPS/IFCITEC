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

    /**
     * Create a new job instance.
     *
     * @param string $conteudo
     * @param string $email
     */
    public function __construct($conteudo, $email)
    {
        $this->conteudo = $conteudo;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new \App\Mail\MailBase($this->conteudo);
        Mail::to($this->email)->send($email);
    }
}