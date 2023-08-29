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

		$projetos['autor'] = Projeto::select('id', 'titulo','nota_revisao','nota_avaliacao','situacao_id')
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

		$projetos['coorientador'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 6) // Coorientador
			->get();
			$situacoes = Situacao::all();
			$revisao = DB::table('revisao')->join('pessoa', 'revisao.pessoa_id', '=', 'pessoa.id')
            ->select('revisao.pessoa_id', 'revisao.observacao', 'revisao.nota_final', 'pessoa.nome')
            ->where('revisao.projeto_id', $projetos['autor'][0]->id)
            ->get()->toArray();
		return view('user.home')->withProjetos($projetos)->withRevisao($revisao)->withSituacoes($situacoes);
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
