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
			$DataFechamentoHom = DB::table('edicao')
			->where('id',Edicao::getEdicaoId())
			->pluck('homologacao_fechamento');
			$DataFechamentoAva = DB::table('edicao')
			->where('id',Edicao::getEdicaoId())
			->pluck('avaliacao_fechamento');
		$projetos['coorientador'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 6) // Coorientador
			->get();
			if(isset($projetos['autor'][0]->id)){
			$homologacao = DB::table('formulario')
				->where('formulario.edicao_id',Edicao::getEdicaoId())
				->where('formulario.nivel_id',$projetos['autor'][0]->nivel_id)
				->where('tipo','homologacao')
				->join('formulario_categoria_avaliacao','formulario.idformulario','formulario_categoria_avaliacao.formulario_idformulario')
				->join('categoria_avaliacao','formulario_categoria_avaliacao.categoria_avaliacao_id','categoria_avaliacao.id')
				->join('campos_avaliacao','categoria_avaliacao.id','campos_avaliacao.categoria_id')
				->join('dados_avaliacao','dados_avaliacao.campo_id','campos_avaliacao.id')
				->where('dados_avaliacao.projeto_id',$projetos['autor'][0]->id)
				->join('revisao','dados_avaliacao.pessoa_id','revisao.pessoa_id')
				->where('revisao.projeto_id',$projetos['autor'][0]->id)
				->select('dados_avaliacao.pessoa_id','valor','observacao','categoria_avaliacao','campos_avaliacao.descricao','nota_final','categoria_avaliacao.peso')
				->distinct()
				->get();		
			$homologacao = $homologacao->groupBy('pessoa_id')->map(function ($itens) {
				return $itens->values()->toArray();
			})->values()->toArray();
			$avaliacao = DB::table('formulario')
			->where('formulario.edicao_id',Edicao::getEdicaoId())
			->where('formulario.nivel_id',$projetos['autor'][0]->nivel_id)
			->where('tipo','avaliacao')
			->join('formulario_categoria_avaliacao','formulario.idformulario','formulario_categoria_avaliacao.formulario_idformulario')
			->join('categoria_avaliacao','formulario_categoria_avaliacao.categoria_avaliacao_id','categoria_avaliacao.id')
			->join('campos_avaliacao','categoria_avaliacao.id','campos_avaliacao.categoria_id')
			->join('dados_avaliacao','dados_avaliacao.campo_id','campos_avaliacao.id')
			->where('dados_avaliacao.projeto_id',$projetos['autor'][0]->id)
			->join('revisao','dados_avaliacao.pessoa_id','revisao.pessoa_id')
			->where('revisao.projeto_id',$projetos['autor'][0]->id)
			->select('dados_avaliacao.pessoa_id','valor','observacao','categoria_avaliacao','campos_avaliacao.descricao','nota_final','categoria_avaliacao.peso')
			->distinct()
			->get();	
			$avaliacao = $avaliacao->groupBy('pessoa_id')->map(function ($itens) {
				return $itens->values()->toArray();
			})->values()->toArray();
			}else{
				$homologacao = null;
				$avaliacao = null;
			}
		

		return view('user.home')
		->withProjetos($projetos)
		->withAvaliacao($avaliacao)
		->withDatahom($DataFechamentoHom[0])
		->withDataava($DataFechamentoAva[0])
		->withHomologacao($homologacao);
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
