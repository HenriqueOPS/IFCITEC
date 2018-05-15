<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use App\Edicao;
use App\Projeto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        /*if(Auth::user()->temFuncao('Organizador')){
            $projetos = $this->groupProjetosPorSituacao(Projeto::all());
            return view('organizacao.home')->withSituacoes($projetos);
        }else if((Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Revisor'))) {
            $query = DB::table('projeto')->select('projeto.*')
                ->join('avaliacao', 'avaliacao.projeto_id', '=', 'projeto.id')
                ->where('pessoa_id','=', Auth::user()->id);

            $eloquent = new Builder($query);
            $eloquent->setModel(new Projeto);
            $projetos = $eloquent->get();
            return view('home')->withFuncoes(collect(["Avaliação" => $projetos]));
        }else{
            $projetos = (Auth::user()->projetos);
            $funcoes = $this->groupProjetosPorFuncao($projetos);
            return view('home')->withFuncoes($funcoes);
        }
        */

        return view('home');

    }


    public function homeAvaliador(){
        $query = DB::table('projeto')->select('projeto.*')
                ->join('avaliacao', 'avaliacao.projeto_id', '=', 'projeto.id')
                ->where('pessoa_id','=', Auth::user()->id);

        $eloquent = new Builder($query);
        $eloquent->setModel(new Projeto);
        $projetos = $eloquent->get();
        return view('avaliador')->withFuncoes(collect(["Avaliação" => $projetos]));

    }

     public function homeRevisor(){
        $query = DB::table('projeto')->select('projeto.*')
                ->join('avaliacao', 'avaliacao.projeto_id', '=', 'projeto.id')
                ->where('pessoa_id','=', Auth::user()->id);

        $eloquent = new Builder($query);
        $eloquent->setModel(new Projeto);
        $projetos = $eloquent->get();
        return view('revisor')->withFuncoes(collect(["Revisão" => $projetos]));

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

    protected function groupProjetosPorSituacao($projetos){
        $projetosAgrupados = array();
        foreach ($projetos as $projeto) {
            $situacao = 0;
            switch ($projeto->getStatus()){
                case "Não Revisado":
                    $situacao = 0;
                    break;
                case "Homologado":
                    $situacao = 1;
                    break;
                case "Homologado com Revisão":
                    $situacao = 2;
                    break;
                case "Reprovado":
                    $situacao = 3;
                    break;
                case "Avaliado":
                    $situacao = 5;
                    break;
                case "Não Compareceu":
                    $situacao = 6;
                    break;
            }
            $projetosAgrupados[$situacao][] = $projeto;
        }
        return (collect($projetosAgrupados));
    }

}
