<?php

namespace App\Http\Controllers\Auth;

use App\Pessoa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
                    'dt_nascimento' => 'required|date_format:d/m/Y|before:today|after:01/01/1950'
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
                    'dt_nascimento' => $data['dt_nascimento'],
                    'camisa' => isset($data['camisa']) ? $data['camisa'] : null,
                    'moodle' => isset($data['moodle']) ? $data['moodle'] : false,
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

}
