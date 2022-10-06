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

class RegisterController extends Controller
{
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
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		//dd($data);

		$messages = [
			'validate_cpf' => 'CPF invalido'
		];

		if (session()->has('email')) {
			$data = $this->setSessionValues($data);
		}

		Validator::extend('validateCpf', function ($field, $cpf, $parameters) {
			// Elimina possivel mascara
			$cpf = preg_replace("/[^0-9]/", "", $cpf);
			$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

			// Verifica se o numero de digitos informados é igual a 11
			if (strlen($cpf) != 11)
				return false;

			// Verifica se nenhuma das sequências invalidas abaixo
			// foi digitada. Caso afirmativo, retorna falso
			else if (
				$cpf == '00000000000' ||
				$cpf == '11111111111' ||
				$cpf == '22222222222' ||
				$cpf == '33333333333' ||
				$cpf == '44444444444' ||
				$cpf == '55555555555' ||
				$cpf == '66666666666' ||
				$cpf == '77777777777' ||
				$cpf == '88888888888' ||
				$cpf == '99999999999'
			) {
				return false;
				// Calcula os digitos verificadores para verificar se o
				// CPF é válido
			} else {
				for ($t = 9; $t < 11; $t++) {
					for ($d = 0, $c = 0; $c < $t; $c++)
						$d += $cpf[$c] * (($t + 1) - $c);

					$d = ((10 * $d) % 11) % 10;

					if ($cpf[$c] != $d) {
						return false;
					}
				}

				return true;
			}
		});

		return Validator::make(
			$data,
			[
				'nome' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:pgsql.pessoa|confirmed',
				'senha' => 'required|string|confirmed',
				'dt_nascimento' => 'required|date_format:d/m/Y|before:today|after:01/01/1900',
				'rg' => 'required|max:10|string|unique:pgsql.pessoa',
				'telefone' => 'required|string|min:13|max:13',
				'cpf' => 'string|unique:pgsql.pessoa|min:11|max:14|validateCpf',
				'confirmacaoRg' => 'required',
				'newletter' => 'boolean',

				//COMECO do código que necessitará um refact issue #40
				//'lattes' => 'required_if:inscricao,avaliacao|string',
				//'cpf' => 'required_if:inscricao,avaliacao|cpf|unique:pgsql.pessoa',
				//FIM do código que necessitará um refact issue #40
			],
			$messages
		);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		dd($data);

		if (session()->has('email')) {
			$data = $this->setSessionValues($data);
			session()->flush();
		}

		return Pessoa::create([
			'nome' => $data['nome'],
			'email' => $data['email'],
			'senha' => bcrypt($data['senha']),
			'dt_nascimento' => Carbon::createFromFormat('d/m/Y', $data['dt_nascimento']),
			'cpf' => isset($data['cpf']) ? $data['cpf'] : null,
			'rg' => isset($data['rg']) ? $data['rg'] : null,
			'camisa' => isset($data['camisa']) ? $data['camisa'] : null,
			'newsletter' => isset($data['newsletter']) ? $data['newsletter'] : false,
			'oculto' => false
		]);
	}

	private function setSessionValues($data)
	{
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
	protected function registered(Request $request, $pessoa)
	{
		/*
        Log::debug("Checking registration");

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
