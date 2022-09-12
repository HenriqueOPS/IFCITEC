<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Pessoa;

use Carbon\Carbon;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

	/**
	 * The number of seconds a token should last.
	 *
	 * @var int
	 */
    protected $expires = 60 * 60; // 1 hora

	/**
	 * The Hasher implementation.
	 *
	 * @var \Illuminate\Contracts\Hashing\Hasher
	 */
	protected $hasher;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');

        $this->hasher = new BcryptHasher();
    }

	/**
	 * Display the password reset view for the given token.
	 *
	 * If no token is present, display the link request form.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  string|null  $token
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showResetForm(Request $request, $token = null) {
		return view('auth.passwords.reset')
			->with([
				'token' => $token,
				'email' => $request->email
			]);
	}

	protected function tokenExpired($createdAt) {
		return Carbon::parse($createdAt)
			->addSeconds($this->expires)
			->isPast();
	}

	public function exists($email, $token) {
		$passwordReset = DB::table('password_resets')
			->where('email', '=', $email)
			->orderBy('created_at', 'desc')
			->limit(1)
			->get()
			->first();

		return $passwordReset &&
			!$this->tokenExpired($passwordReset->created_at) &&
			$this->hasher->check($token, $passwordReset->token);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function reset(Request $request) {
		$this->validate($request, $this->rules());

		//XGH
		//reseta na mão pq o laravel não acha a model de pessoa
		$data = $this->credentials($request);

		if (!$this->exists($data['email'], $data['token']))
			return $this->sendResetFailedResponse(
				$request,
				'Opps, tempo limite para a troca de senha foi atingido, por gentileza solicite novamente.'
			);

		$pessoa = Pessoa::findByEmail($data['email']);
		$this->resetPassword($pessoa, $data['senha']);

		return redirect('home');
	}

	/**
	 * Get the password reset validation rules.
	 *
	 * @return array
	 */
	protected function rules() {
		return [
			'token' => 'required',
			'email' => 'required|email',
			'senha' => 'required|confirmed|min:6',
		];
	}

	/**
	 * Get the password reset validation error messages.
	 *
	 * @return array
	 */
	protected function validationErrorMessages() {
		return [];
	}

	/**
	 * Get the password reset credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	protected function credentials(Request $request) {
		return $request->only(
			'email',
			'senha',
			'token'
		);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
	 * @param  string  $password
	 * @return void
	 */
	protected function resetPassword($pessoa, $senha) {
		$pessoa->forceFill([
			'senha' => bcrypt($senha),
			'remember_token' => Str::random(60),
		])->save();

		$this->guard()->login($pessoa);
	}

	/**
	 * Get the response for a successful password reset.
	 *
	 * @param  string  $response
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendResetResponse($response) {
		return redirect($this->redirectPath())
			->with('status', trans($response));
	}

	/**
	 * Get the response for a failed password reset.
	 *
	 * @param  \Illuminate\Http\Request
	 * @param  string  $response
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendResetFailedResponse(Request $request, $error) {
		return redirect()
			->back()
			->withInput($request->only('email'))
			->withErrors([
				'email' => trans($error)
			]);
	}

	/**
	 * Get the broker to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\PasswordBroker
	 */
	public function broker()
	{
		return Password::broker();
	}

	/**
	 * Get the guard to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard();
	}

}

