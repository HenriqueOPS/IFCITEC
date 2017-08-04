<?php

namespace App\Http\Controllers\Auth;

use App\Pessoa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        if (session()->has('email')) {
            $data = $this->setSessionValues($data);
        }

        return Validator::make($data, [
                    'nome' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:pgsql.pessoa',
                    'senha' => 'required|string|confirmed',
                    'dt_nascimento' => 'required|date_format:d/m/Y|before:today|after:01/01/1950',
                    //COMECO do código que necessitará um refact issue #40
                    'titulacao' => 'required_if:inscricao,avaliacao|string',
                    'lattes' => 'required_if:inscricao,avaliacao|string',
                    'profissao' => 'required_if:inscricao,avaliacao|string',
                    'instituicao' => 'required_if:inscricao,avaliacao|string',
                    'cpf' => 'required_if:inscricao,avaliacao|cpf|unique:pgsql.pessoa',
                    'titulacao' => 'required_if:inscricao,avaliacao|string',
                    'numero' => 'required_if:inscricao,avaliacao|integer',
                    'bairro' => 'required_if:inscricao,avaliacao|string',
                    'cidade' => 'required_if:inscricao,avaliacao|string',
                    'estado' => 'required_if:inscricao,avaliacao|string',
                    'cep' => 'required_if:inscricao,avaliacao',
                        //FIM do código que necessitará um refact issue #40
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {

        if (session()->has('email')) {
            $data = $this->setSessionValues($data);
            session()->flush();
        }

        return Pessoa::create([
                    'nome' => $data['nome'],
                    'email' => $data['email'],
                    'senha' => bcrypt($data['senha']),
                    'dt_nascimento' => Carbon::createFromFormat('d/m/Y', $data['dt_nascimento']),
                    'camisa' => isset($data['camisa']) ? $data['camisa'] : null,
                    'moodle' => isset($data['moodle']) ? $data['moodle'] : false,
                    //COMECO do código que necessitará um refact issue #40
                    'cpf' => isset($data['cpf']) ? $data['cpf'] : null,
                    'titulação' => isset($data['titulacao']) ? $data['titulacao'] : null,
                    'lattes' => isset($data['lattes']) ? $data['lattes'] : null,
                    'profissao' => isset($data['profissao']) ? $data['profissao'] : null,
                    'instituicao' => isset($data['instituicao']) ? $data['instituicao'] : null
                    //FIM do código que necessitará um refact issue #40
        ]);
    }

    private function setSessionValues($data) {
        $data['email'] = session('email');
        $data['nome'] = session('nome');
        $data['senha'] = session('email');
        $data['senha_confirmation'] = session('email');
        $data['moodle'] = true;
        return $data;
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $pessoa) {
        if ($request->inscricao == "avaliacao") {
            $pessoa->funcoes()->attach($request->funcao);
        } else {
            $pessoa->funcoes()->attach(1);
        }
        $pessoa->save();
    }

}
