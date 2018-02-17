<?php

namespace App\Http\Controllers\Auth;

use App\Pessoa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
//
use App\Endereco;

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
                    'dt_nascimento' => 'required|date_format:d/m/Y|before:today|after:01/01/1900',
                    'rg' => 'required|string|unique:pgsql.pessoa',
                    'telefone' => 'string|min:8|max:15',
                    'cpf' => 'string|unique:pgsql.pessoa|min:11|max:14',
                    'confirmacaoRg' => 'required'

                    //COMECO do código que necessitará um refact issue #40
                    //'lattes' => 'required_if:inscricao,avaliacao|string',
                    //'cpf' => 'required_if:inscricao,avaliacao|cpf|unique:pgsql.pessoa',
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
                    'cpf' => isset($data['cpf']) ? $data['cpf'] : null,
                    'rg' => isset($data['rg']) ? $data['rg'] : null
                    //COMECO do código que necessitará um refact issue #40
                    //'cpf' => isset($data['cpf']) ? $data['cpf'] : null,
                    //'lattes' => isset($data['lattes']) ? $data['lattes'] : null,
                    //FIM do código que necessitará um refact issue #40
        ]);
    
    }

    private function setSessionValues($data) {
        $data['email'] = session('email');
        $data['nome'] = session('nome');
        $data['senha'] = session('email');
        $data['senha_confirmation'] = session('email');
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
        
        /*
        if ($request->inscricao == "avaliacao") {
            $pessoa->funcoes()->attach($request->funcao);
            //COMECO do código que necessitará um refact issue #40
            $endereco = new Endereco();
            $endereco->fill($request->all());
            // dd($endereco);
            $endereco->pessoa()->associate($pessoa);
            $endereco->save();
            //FIM do código que necessitará um refact issue #40
        } else {
            $pessoa->funcoes()->attach(1);
        }
        $pessoa->save();
        */
        
    }

}
