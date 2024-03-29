<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use App\Erro;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // if(env('APP_DEBUG'))
            parent::report($exception);

        // return response()->view('errors.custom', [], 500);

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
		try {
			return parent::render($request, $exception);

			if ($exception instanceof AuthenticationException) {
				return parent::render($request, $exception);
			}

			//Log::error("Excessão gerada. Informações detalhadas: " . $exception->getTraceAsString());
			$erro = Erro::where('fingerprint', '=', $request->fingerprint())->first();

			if ($erro === null) {
				$erroEloquent = new Erro();
				$erroEloquent->fill([
					'descricao_erro' => $exception->getMessage(),
					'fingerprint' => $request->fingerprint()
				]);
				$erroEloquent->save();

				return view(
					'errors.custom',
					[
						'error' => $exception->getMessage(),
						'erro_id' => $erroEloquent->getId(),
						'fingerprint' => $request->fingerprint()
					]
				);
			}

			$erro->incrementarDescricaoErro("\n" . $exception->getMessage());
			$erro->save();

        	return view(
				'errors.custom',
				[
					"error" => $exception->getMessage(),
					"erro_id" => $erro->getId(),
					"fingerprint" => $erro->getFingerprint()
				]
			);
		} catch(Exception $e){
			return parent::render($request, $exception);
		}
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
