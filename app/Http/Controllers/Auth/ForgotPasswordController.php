<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailSenhaJob;
use App\Mail\MailSenha;
use App\Pessoa;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function emailSenha(Request $req)
    {
        $data = $req->all();

        if (Pessoa::where('email', $data['email'])->count()) {

            $hasher = new BcryptHasher();
            $token = Str::random(64);

            DB::table('password_resets')
                ->insert([
                    'email' => $data['email'],
                    'token' => $hasher->make($token),
                    'created_at' => DB::raw('now()')
                ]);

            // CÓDIGO ORIGINAL
            /*$emailJob = (new MailSenhaJob($data['email'], $token))
				->delay(\Carbon\Carbon::now()->addSeconds(3));
			dispatch($emailJob);*/

            //dispatch(new MailSenhaJob($data['email'], $token));
            dispatch(
                new \App\Jobs\MailBaseJob(
                    $data['email'],
                    'Resetar Senha',
                    [
                        'token' => $token
                    ]
                )
            );

            return view('auth.passwords.email', [
                'success' => 'O email de recuperação de senha foi enviado com sucesso'
            ]);
        }

        return view('auth.passwords.email', [
            'error' => 'O email informado não está cadastro no sistema'
        ]);
    }
}
