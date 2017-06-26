<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Escola;
use App\Pessoa;
use App\Services\MoodleAuthService;
use App\Exceptions\MoodleErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Description of moodleAuthController
 *
 * @author filipe_oliveira
 */
class MoodleAuthController extends Controller {

    private $moodleService;

    public function __construct(MoodleAuthService $moodleService) {
        $this->moodleService = $moodleService;
        $this->middleware('guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $escolas = Escola::temMoodle()->get();
        return view('auth.moodle.login')->withEscolas($escolas);
    }

    public function autenticar(Request $request) {
        $escola = Escola::find($request->escola);

        // TODO: Implementar acesso de parametros via Request
        try {
            $user = $this->moodleService->autenticar($escola, $request);
            
            $pessoa = Pessoa::findByEmail($user['email']);
            
            if (is_null($pessoa)) {
                $pessoa = Pessoa::create([
                            'nome' => $user['fullname'],
                            'email' => $user['email'],
                            'senha' => bcrypt(null),
                            'dt_nascimento' => '01/01/1998',
                ]);
                return view('auth.moodle.register')->withPessoa($pessoa);
            } else {
               return $this->fazerLogin($pessoa);
            }
        } catch (MoodleErrorException $e) {
            dd($e->message);
        }
    }

    public function registrar(Request $request) {
        $pessoa = Pessoa::findByEmail($request->email);

        $pessoa->cpf = $request->cpf;
        $pessoa->dt_nascimento = $request->dt_nascimento;
        $pessoa->camisa = isset($request->camisa) ? $request->camisa : null;
        $pessoa->save();

        return $this->fazerLogin($pessoa);
    }
    
    private function fazerLogin(Pessoa $pessoa){
         if (Auth::attempt(['email' => $pessoa->email, 'password' => null])) {
            return redirect('home');
        }
    }

}
