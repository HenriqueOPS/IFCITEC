<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailSenhaJob;
use App\Pessoa;

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
        if(! Pessoa::where('email',$data['email'])->get()->isEmpty()){
        $emailJob = (new MailSenhaJob($data['email'], $data['_token']))->delay(\Carbon\Carbon::now()->addSeconds(3));
        dispatch($emailJob);
        $req->session()->flash('status', 'O email de recuperação de senha foi enviado com sucesso');
        return view('auth.passwords.email');
        }
        else{
            return view('auth.passwords.email', array('error' => 'Algo deu errado com o e-mail informado'));
        }
    }
}
