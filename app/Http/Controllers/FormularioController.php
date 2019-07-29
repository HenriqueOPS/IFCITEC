<?php

namespace App\Http\Controllers;

use App\Edicao;
use App\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormularioController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index ($tipo, $id) {

		if($tipo == 'avaliacao' || $tipo == 'homologacao') {

			// valida se é o homologador/avaliador do projeto
			if ($tipo == 'homologacao') {
				$isHomologador = DB::table('revisao')
					->where('projeto_id', '=', $id)
					->where('pessoa_id', '=', Auth::id())
					->get();

				if ($isHomologador->count() == 0 || $isHomologador[0]->revisado)
					return redirect()->route('home');
			} else {
				$isAvaliador = DB::table('avaliacao')
					->where('projeto_id', '=', $id)
					->where('pessoa_id', '=', Auth::id())
					->get();

				if ($isAvaliador->count() == 0 || $isAvaliador[0]->avaliado)
					return redirect()->route('home');
			}

			$projeto = Projeto::find($id);

			$categorias = DB::table('categoria_avaliacao')
				->select('*')
				->join('formulario_categoria_avaliacao', 'categoria_avaliacao.id', '=', 'formulario_categoria_avaliacao.categoria_avaliacao_id')
				->join('formulario', 'formulario.idformulario', '=', 'formulario_categoria_avaliacao.formulario_idformulario')
				->where('formulario.tipo', '=', $tipo) // homologação/avaliação
				->where('formulario.edicao_id', '=', Edicao::getEdicaoId()) // id da edição corrente
				->where('formulario.nivel_id', '=', $projeto->nivel_id) // nivel
				->get()->toArray();

			$countCampos = 0;
			foreach ($categorias as $key => $categoria) {

				$campos_avaliacao = DB::table('campos_avaliacao')
					->select('*')
					->where('categoria_id', '=', $categoria->categoria_avaliacao_id)
					->where('edicao_id', '=', Edicao::getEdicaoId())
					->where('nivel_id', '=', $categoria->nivel_id)
					->get()->toArray();

				$categorias[$key]->campos = $campos_avaliacao;
				$countCampos += count($campos_avaliacao);

			}

			return view('comissao.formulario', compact('projeto', 'categorias', 'countCampos', 'tipo'));
		}

		return redirect()->route('home');
	}

	public function store(Request $req) {

		$data = $req->all();

		// valida se é o homologador/avaliador do projeto
		if ($data['tipo'] == 'homologacao') {
			$isHomologador = DB::table('revisao')
				->where('projeto_id', '=', $data['idProjeto'])
				->where('pessoa_id', '=', Auth::id())
				->get();

			if ($isHomologador->count() == 0)
				return response()->json(['erro' => 'pessoa não vinculada para avaliar o projeto'], 400);
		} else {
			$isAvaliador = DB::table('avaliacao')
				->where('projeto_id', '=', $data['idProjeto'])
				->where('pessoa_id', '=', Auth::id())
				->get();

			if ($isAvaliador->count() == 0)
				return response()->json(['erro' => 'pessoa não vinculada para avaliar o projeto'], 400);
		}

		$notaFinal = 0;
		foreach ($data['categorias'] as $idCategoria => $campos) {

			$categoria = DB::table('categoria_avaliacao')
				->where('id', '=', $idCategoria)
				->get()
				->first();

			$pesoCategoria = $categoria->peso / 10;
			$pesoCampo = 10 / count($campos); // calcula o peso do campo

			$sumCampos = 0;
			// somatório dos campos
			foreach ($campos as $id => $campo) {

				// salva os valores dos campos
				DB::table('dados_avaliacao')
					->insert([
						'projeto_id' => $data['idProjeto'],
						'valor' => ($campo / 100),
						'campo_id' => $id,
						'pessoa_id' => Auth::id()
					]);

				$sumCampos += $campo / 100; // deixa o valor do campo em no máximo 1
			}

			$notaFinal += ($sumCampos * $pesoCampo) * $pesoCategoria;

		}

		// salva a nota de homologação ou avaliação
		if ($data['tipo'] == 'homologacao') {

			DB::table('revisao')
				->where('projeto_id', '=', $data['idProjeto'])
				->where('pessoa_id', '=', Auth::id())
				->update([
					'nota_final' => $notaFinal,
					'observacao' => $data['observacao'],
					'revisado' => true
				]);

			//altera a média da nota de homologação na tabela de projeto
			$subQuery = DB::table('revisao')
				->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
				->where('revisao.projeto_id','=',DB::raw('projeto.id'))
				->toSql();

			Projeto::select('projeto.id')
				->where('projeto.id', '=', $data['idProjeto'])
				->update(['nota_revisao' =>  DB::raw('('.$subQuery.')')]);

		} else { // avaliacao

			DB::table('avaliacao')
				->where('projeto_id', '=', $data['idProjeto'])
				->where('pessoa_id', '=', Auth::id())
				->update([
					'nota_final' => $notaFinal,
					'observacao' => $data['observacao'],
					'avaliado' => true
				]);

			//altera a média da nota de avaliação na tabela de projeto
			$subQuery = DB::table('avaliacao')
				->select(DB::raw('COALESCE(AVG(avaliacao.nota_final),0)'))
				->where('avaliacao.projeto_id','=',DB::raw('projeto.id'))
				->toSql();

			Projeto::select('projeto.id')
				->where('projeto.id', '=', $data['idProjeto'])
				->update(['nota_avaliacao' =>  DB::raw('('.$subQuery.')')]);


			//verifica se o projeto já foi avaliado por todos avaliadores
			$cont = DB::table('avaliacao')
				->select('id')
				->where('projeto_id', '=', $data['idProjeto'])
				->where('avaliado', '=', false)
				->get();

			if($cont->count() == 0)
				Projeto::find($data['idProjeto'])->update(['situacao_id' => 5]);

		}

		return response()->json([ 'notaFinal' => $notaFinal], 200);

	}



}
