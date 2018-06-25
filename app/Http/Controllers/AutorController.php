<?php

namespace App\Http\Controllers;

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
        $funcoes = DB::table('funcao_pessoa')->select('funcao_id')->where('pessoa_id', '=', Auth::user()->id)->get();
        $projetoPessoa = DB::table('escola_funcao_pessoa_projeto')->select('projeto_id')->where('pessoa_id', '=', Auth::user()->id)->get()->keyBy('projeto_id')->toArray();
        $chaves = array_keys( $projetoPessoa);
        $projetos = DB::table('projeto')->select('id','resumo','titulo')->whereIn('id', $chaves)->get()->keyBy('id')->toArray();
        
        if(isset($projetos) == false){
            $projetos = (array) null;
        }
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
        return view('user.home', array('projetos' => $projetos), array('autor' => $autor), array('coorientador' => $coorientador))->withFuncoes($funcoes)->withOrientador($orientador)->withCoorientador($coorientador);
    }
}