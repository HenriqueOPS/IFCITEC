<?php

namespace App\Http\Controllers;

use App\Campo;
use App\Categoria;
use App\Edicao;
use App\Formulario;
use App\Nivel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\categoriaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichaController extends Controller
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
    public function index() {

    	$formularios = Formulario::select('*')
			->join('nivel', 'nivel.id', '=', 'nivel_id')
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->get();

    	return view('admin.fichas.home', compact('formularios'));

    }

	public function novaFicha() {
    	$niveis = Nivel::select('nivel.*')
			->join('nivel_edicao', 'nivel_id', '=', 'nivel.id')
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->get();

		return view('admin.fichas.create', compact('niveis'));

	}

	public function salvaFicha(Request $request) {

    	$data = $request->all();

    	// VALIDAÇÃO
		$schemaValidacao = [
			'nivel' => 'required',
			'tipo' => 'required'
		];

		// valida campos requeridos
		// $request->validate($schemaValidacao);

		// valida se já tem um cadastro do mesmo tipo pra mesma área e na mesma edição
		$formExists = Formulario::where('tipo', '=', $data['tipo'])
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->where('nivel_id', '=', $data['nivel'])
			->get();

		if ($formExists->count())
			return response()->json([ 'error' => 'Já existe um formulário deste mesmo tipo para essa mesma edição' ], 400);

		// valida se os pesos chegam a 10
		$pesos = 0;
		foreach ($data['categorias'] as $categoria)
			$pesos += $categoria['peso']; // somatório dos pesos

		if ($pesos != 10)
			return response()->json([ 'error' => 'O somatório dos pesos não pode ser diferente de 10' ], 400);
		// FIM VALIDAÇÃO

    	// salva o formulario
		$formulario = Formulario::create([
			'nivel_id' => $data['nivel'],
			'edicao_id' => Edicao::getEdicaoId(),
			'tipo' => $data['tipo'],
		]);

		// salva as categorias
		foreach ($data['categorias'] as $categoria) {

			$categoriaAvaliacao = Categoria::create([
				'categoria_avaliacao' => $categoria['nome'],
				'peso' => $categoria['peso'],
				'descricao' => '',
				'edicao_id' => Edicao::getEdicaoId(),
				'nivel_id' => $data['nivel']
			]);

			// TODO: inserir id do fomulário em categoria avaliação, mas como não é minha parte azar
			// vincula categoria avaliacao com o formulario
			DB::table('formulario_categoria_avaliacao')
				->insert([
					'categoria_avaliacao_id' => $categoriaAvaliacao->id,
					'formulario_idformulario' => $formulario->idformulario
				]);

			// salva os campos
			foreach ($categoria['campos'] as $campo) {

				DB::table('campos_avaliacao')
					->insert([
						'peso' => 0, // TODO: remver esse campo
						'categoria_id' => $categoriaAvaliacao->id,
						'edicao_id' => Edicao::getEdicaoId(),
						'nivel_id' => $data['nivel'],
						'descricao' => ($campo['nome'] ?? ''),

						'val_0' => ($campo['0'] ?? false),
						'val_25' => ($campo['25'] ?? false),
						'val_50' => ($campo['50'] ?? false),
						'val_75' => ($campo['75'] ?? false),
						'val_100' => ($campo['100'] ?? false)
					]);

			}
		}

		return response()->json($data, 200);
	}

}
