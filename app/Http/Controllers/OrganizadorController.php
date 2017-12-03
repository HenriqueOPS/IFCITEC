<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use App\Projeto;
use Illuminate\Http\Request;

class OrganizadorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isOrganizacao');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $projetos = $this->groupProjetosPorSituacao(Projeto::all());
        return view('organizacao.home')->withSituacoes($projetos);

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
