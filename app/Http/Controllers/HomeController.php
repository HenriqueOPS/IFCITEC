<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Funcao;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $projetos = (Auth::user()->projetos);
        $funcoes = $this->groupProjetosPorFuncao($projetos);
        return view('home')->withFuncoes($funcoes);
    }

    protected function groupProjetosPorFuncao($projetos) {
        $funcoes = Funcao::all();
        $projetosAgrupados = array();
        foreach ($funcoes as $funcao) {
            foreach ($projetos as $projeto) {
                if ($projeto->pivot->funcao_id === $funcao->id) {
                    $projetosAgrupados[$funcao->funcao][] = $projeto;
                }
            }
        }
        return collect($projetosAgrupados);
    }

}
