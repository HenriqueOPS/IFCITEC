<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Jobs\MailBaseJob;
use App\Pessoa;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public static function enviarEmailValidacao(int $idPessoa)
    {
        $pessoa = Pessoa::all()->where('id', '=', $idPessoa)->first();
        dispatch(
            new MailBaseJob(
                $pessoa->email,
                'Verificacao de Cadastro',
                [
                    'nome' => $pessoa->nome,
                    'idPessoa' => $idPessoa,
                ]
            )
        );
    }

    public static function validarUsuario(int $idPessoa)
    {

        DB::table('pessoa')
            ->where('id', '=', $idPessoa)
            ->limit(1)
            ->update(['verificado' => true]);

        return view('auth.verificado');
    }

    public function authenticate(LoginRequest $req)
    {
        $user = Pessoa::all()->where('email', '=', $req->email)->first();

        if (!$user->verificado) {
            $this->enviarEmailValidacao($user->id);
            return view('auth.verificar', ['idPessoa' => $user->id]);
        }

        Auth::login($user);
        return redirect()->intended('/home');
    }
}
