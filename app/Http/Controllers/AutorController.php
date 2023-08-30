<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Situacao;
use Illuminate\Support\Facades\DB;
use App\Edicao;
use App\Projeto;

class AutorController extends Controller {
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
		$projetos = [];

		$projetos['autor'] = Projeto::select('id', 'titulo','nota_revisao','nota_avaliacao','situacao_id','nivel_id')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 5) // Autor
			->get();

		$projetos['orientador'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 7) // Orientador
			->get();
			$DataFechamento = DB::table('edicao')
			->where('id',Edicao::getEdicaoId())
			->pluck('homologacao_fechamento');
		$projetos['coorientador'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 6) // Coorientador
			->get();
			$situacoes = Situacao::all();
			if(isset($projetos['autor'][0]->id)){
				$revisao = DB::table('revisao')->join('pessoa', 'revisao.pessoa_id', '=', 'pessoa.id')
            ->select('revisao.pessoa_id', 'revisao.observacao', 'revisao.nota_final', 'pessoa.nome')
            ->where('revisao.projeto_id', $projetos['autor'][0]->id)
            ->get()->toArray();
			$campos = DB::table('campos_avaliacao')
			->where('campos_avaliacao.edicao_id',Edicao::getEdicaoId())
			->where('campos_avaliacao.nivel_id', $projetos['autor'][0]->nivel_id)
			->join('dados_avaliacao','dados_avaliacao.campo_id','campos_avaliacao.id')
			->where('dados_avaliacao.projeto_id',$projetos['autor'][0]->id)
			->join('categoria_avaliacao','campos_avaliacao.categoria_id','categoria_avaliacao.id')
			->select('dados_avaliacao.pessoa_id','categoria_avaliacao.categoria_avaliacao','categoria_avaliacao.peso','dados_avaliacao.valor','campos_avaliacao.descricao')
			->get();
			
			$campos = $campos->groupBy('pessoa_id')->map(function ($itens) {
				return $itens->values()->toArray();
			})->values()->toArray();
			
		
			}else{
				$campos = null;
				$revisao=null;
			}
		

		return view('user.home',)
		->withProjetos($projetos)
		->withRevisao($revisao)
		->withSituacoes($situacoes)
		->withCampos($campos)
		->withData($DataFechamento[0]);
    }
	public function nota($id){
		$projeto = Projeto::find($id);
        $situacoes = Situacao::all();

        $revisao = DB::table('revisao')->join('pessoa', 'revisao.pessoa_id', '=', 'pessoa.id')
            ->select('revisao.pessoa_id', 'revisao.observacao', 'revisao.nota_final', 'pessoa.nome')
            ->where('revisao.projeto_id', $id)
            ->get()->toArray();
    
	}

}
