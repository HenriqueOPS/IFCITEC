<?php

namespace App\Http\Controllers;

use App\Edicao;
use App\Projeto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Funcao;
use App\Pessoa;

class AutorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$projetosPessoa = DB::table('escola_funcao_pessoa_projeto')
							->select(['projeto_id','funcao'])
							->where('pessoa_id', '=', Auth::user()->id)
							->where('edicao_id', '=', Edicao::getEdicaoId())
							->join('funcao','funcao_id','=','funcao.id')
							->get()
							->toArray();

		$projetosIDs = array_column($projetosPessoa, 'projeto_id');

		$integrantes = DB::table('escola_funcao_pessoa_projeto')
								->select(['projeto_id','nome'])
								->whereIn('projeto_id', $projetosIDs)
								->join('pessoa','pessoa_id','=','pessoa.id')
								->get()
								->toArray();

        $projetos = DB::table('projeto')
						->select('id','resumo','titulo')
						->whereIn('id', $projetosIDs)
						->get()
						->keyBy('id')
						->toArray();

        /*
        if($projetos != null){
        $idAutor =  Funcao::where('funcao','Autor')-> first();
        $idOrientador =  Funcao::where('funcao','Orientador')-> first();
        $idCoorientador =  Funcao::where('funcao','Coorientador')-> first();

        $ids = array_keys( $projetos);

        $autor = DB::table('escola_funcao_pessoa_projeto')->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')->whereIn('projeto_id', $ids)->where('funcao_id', $idAutor->id)->get()->toArray();
        $orientador = DB::table('escola_funcao_pessoa_projeto')->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')->whereIn('projeto_id', $ids)->where('funcao_id', $idOrientador->id)->get()->toArray();
        $coorientador = DB::table('escola_funcao_pessoa_projeto')->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')->whereIn('projeto_id', $ids)->where('funcao_id', $idCoorientador->id)->get()->toArray();
        }
        else{
            $autor = (array) null;
            $orientador = null;
            $coorientador = (array) null;
        }
        if(! isset($coorientador)){
            $coorientador = (array) null;
        }
		*/

		$autor = array();
		$orientador = array();
		$coorientador = array();

        return view('user.home', compact('projetosPessoa','projetos', 'integrantes'))
			->withOrientador($orientador)
			->withCoorientador($coorientador);
    }
}
