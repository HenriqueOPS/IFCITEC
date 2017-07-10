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

        try {
            $user = $this->moodleService->autenticar($escola, $request);

            $pessoa = Pessoa::findByEmail($user['email']);

            if ($pessoa instanceof Pessoa) { //Se ela já existe no sistema
                return $this->verificaSeRegistroMoodle($pessoa);
            } else {//Se é necessário cadastrar pessoa
                session(['email' => $user['email'], 'nome' => $user['fullname']]);
                //Fazer via rota, comparando se há um hash na seção
                return view('auth.moodle.register')->withEmail($user['email'])->withNome($user['fullname']);
            }
        } catch (MoodleErrorException $e) { //Se o webservice retornou alguma mensagem de erro
            return back()->withErrors(["moodleError" => $e->message]);
        }
    }

    private function fazerLogin(Pessoa $pessoa) {
        if (Auth::attempt(['email' => $pessoa->email, 'password' => $pessoa->email])) {
            return redirect('home');
        }
    }

    private function verificaSeRegistroMoodle(Pessoa $pessoa) {
        return ($pessoa->moodle)
                //Caso esta pessoa existente tenha feito registro via moodle (Isso afeta na senha do auth)
                ? $this->fazerLogin($pessoa)
                //Caso esta pessoa existenta tenha feito registro padrão
                : back()->withErrors(["moodleError" => "Este email já esta vinculado com outro usuário do sistema"]);
    }

}
