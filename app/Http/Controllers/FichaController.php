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

	public function show($id) {

		$formulario = Formulario::select('*')
			->join('nivel', 'nivel.id', '=', 'nivel_id')
			->where('idformulario', '=', $id)
			->get()->first();

		$categorias = DB::table('categoria_avaliacao')
			->select('*')
			->join('formulario_categoria_avaliacao', 'categoria_avaliacao.id', '=', 'formulario_categoria_avaliacao.categoria_avaliacao_id')
			->join('formulario', 'formulario.idformulario', '=', 'formulario_categoria_avaliacao.formulario_idformulario')
			->where('formulario.idformulario', '=', $id)
			->get()->toArray();

		foreach ($categorias as $key => $categoria) {

			$campos_avaliacao = DB::table('campos_avaliacao')
				->select('*')
				->where('categoria_id', '=', $categoria->categoria_avaliacao_id)
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('nivel_id', '=', $categoria->nivel_id)
				->get()->toArray();

			$categorias[$key]->campos = $campos_avaliacao;
		}

		return view('admin.fichas.show', compact('categorias', 'formulario'));
	}

	public function create() {
		$niveis = Nivel::select('nivel.*')
			->join('nivel_edicao', 'nivel_id', '=', 'nivel.id')
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->get();

		return view('admin.fichas.create', compact('niveis'));
	}

	public function store(Request $request) {

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
					'formulario_idformulario' => $formulario->idformulario,
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

	public function edit($id) {
		$formulario = Formulario::select('*')
			->join('nivel', 'nivel.id', '=', 'nivel_id')
			->where('idformulario', '=', $id)
			->get()->first();

		$categorias = DB::table('categoria_avaliacao')
			->select('*')
			->join('formulario_categoria_avaliacao', 'categoria_avaliacao.id', '=', 'formulario_categoria_avaliacao.categoria_avaliacao_id')
			->join('formulario', 'formulario.idformulario', '=', 'formulario_categoria_avaliacao.formulario_idformulario')
			->where('formulario.idformulario', '=', $id)
			->get()->toArray();

		foreach ($categorias as $key => $categoria) {

			$campos_avaliacao = DB::table('campos_avaliacao')
				->select('*')
				->where('categoria_id', '=', $categoria->categoria_avaliacao_id)
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('nivel_id', '=', $categoria->nivel_id)
				->get()->toArray();

			$categorias[$key]->campos = $campos_avaliacao;
		}

		return view('admin.fichas.edit', compact('formulario','categorias'));
	}

	public function update(Request $request) {

		$data = $request->all();

		// valida se os pesos chegam a 10
		$pesos = 0;
		foreach ($data['categorias'] as $categoria)
			$pesos += $categoria['peso']; // somatório dos pesos

		// se o somatório dos pesos for diferente de 10
		if ($pesos != 10)
			return response()->json([ 'error' => 'O somatório dos pesos não pode ser diferente de 10' ], 400);
		// FIM VALIDAÇÃO

		// recupera os dados do formulário
		$formulario = Formulario::find($data['id']);

		$categorias = [];
		$categoriaIds = [];
		foreach ($data['categorias'] as $categoriaId => $value) {

			// se o indice do campo começar com underline seta como nulo o id
			// o id nulo representa um campo inexistente, posteriormente será feito o create

			$categoriaId = (substr($categoriaId, 0, 1) != '_') ? $categoriaId : null;
			$categoria = [
				'id' => $categoriaId,
				'nome' => $value['nome'],
				'peso' => $value['peso'],
				'campos' => [],
			];

			foreach ($value['campos'] as $campoId => $campo) {
				$campo['id'] = (substr($campoId, 0, 1) != '_') ? $campoId : NULL;
				array_push($categoria['campos'], $campo);
			}

			// agrupa os ids existentes que vieram no request
			if (!is_null($categoriaId))
				array_push($categoriaIds, $categoriaId);

			array_push($categorias, $categoria);
		}

		try {
			// recupera os ids das categorias anteriormente salvas em banco
			$idCategoriasDB = DB::table('categoria_avaliacao')
				->select('categoria_avaliacao.id')
				->join('formulario_categoria_avaliacao', 'categoria_avaliacao.id', '=', 'formulario_categoria_avaliacao.categoria_avaliacao_id')
				->join('formulario', 'formulario.idformulario', '=', 'formulario_categoria_avaliacao.formulario_idformulario')
				->where('formulario.idformulario', '=', $formulario->idformulario)
				->get()
				->toArray();

			$idCategoriasDB = array_column($idCategoriasDB, 'id');

			// compara as categorias salvas com as do request
			$categoriasToDelete = array_diff($idCategoriasDB, $categoriaIds);


			// deleta as categorias removidas
			foreach ($categoriasToDelete as $categoriaId) {

				// deleta os campos da categoria
				DB::table('campos_avaliacao')
					->where('categoria_id', '=', $categoriaId)
					->delete();

				DB::table('formulario_categoria_avaliacao')
					->where('formulario_idformulario', '=', $formulario->idformulario)
					->where('categoria_avaliacao_id', '=', $categoriaId)
					->delete();

				// deleta a categoria
				Categoria::find($categoriaId)->delete();

			}

			// altera e/ou cria as categorias e campos
			foreach ($categorias as $categoria) {

				$categoriaId = (!is_null($categoria['id'])) ? $categoria['id'] : null;

				// cadastra uma nova categoria
				if (is_null($categoriaId)) {

					$categoriaAvaliacao = Categoria::create([
						'categoria_avaliacao' => $categoria['nome'],
						'peso' => $categoria['peso'],
						'descricao' => '',
						'edicao_id' => $formulario->edicao_id,
						'nivel_id' => $formulario->nivel_id
					]);

					// TODO: inserir id do fomulário em categoria_avaliação e remover essa tabela
					// vincula categoria avaliacao com o formulario
					DB::table('formulario_categoria_avaliacao')
						->insert([
							'categoria_avaliacao_id' => $categoriaAvaliacao->id,
							'formulario_idformulario' => $formulario->idformulario,
						]);

					$categoriaId = $categoriaAvaliacao->id;

					// altera uma categoria já existente
				} else {
					Categoria::find($categoriaId)
						->update([
							'categoria_avaliacao' => $categoria['nome'],
							'peso' => $categoria['peso'],
						]);
				}

				// pega o id dos campos do request
				$camposIds = [];
				foreach ($categoria['campos'] as $campo) {
					$campoId = $campo['id'];

					if (!is_null($campoId))
						array_push($camposIds, $campoId);
				}

				// pega os ids dos campos vinculados a categoria salvos no banco
				$idCamposBD = DB::table('campos_avaliacao')
					->select('id')
					->where('categoria_id', '=', $categoriaId)
					->get()->toArray();

				$idCamposBD = array_column($idCamposBD, 'id');

				// compara os campos salvos com os do request
				$camposToDelete = array_diff($idCamposBD, $camposIds);

				// deleta os campos removidos
				foreach ($camposToDelete as $campoId) {

					DB::table('campos_avaliacao')
						->where('id', '=', $campoId)
						->delete();

				}

				// altera e/ou cria os campos
				foreach ($categoria['campos'] as $campo) {

					// cadastra um novo campo
					if (is_null($campo['id'])) {

						DB::table('campos_avaliacao')
							->insert([
								'peso' => 0, // TODO: remover esse campo
								'categoria_id' => $categoriaId,
								'edicao_id' => $formulario->edicao_id,
								'nivel_id' => $formulario->nivel_id,
								'descricao' => ($campo['nome'] ?? ''),

								'val_0' => ($campo['0'] ?? false),
								'val_25' => ($campo['25'] ?? false),
								'val_50' => ($campo['50'] ?? false),
								'val_75' => ($campo['75'] ?? false),
								'val_100' => ($campo['100'] ?? false)
							]);

						// altera um campo existente
					} else {

						DB::table('campos_avaliacao')
							->where('id', '=', $campo['id'])
							->update([
								'descricao' => ($campo['nome'] ?? ''),

								'val_0' => ($campo['0'] ?? false),
								'val_25' => ($campo['25'] ?? false),
								'val_50' => ($campo['50'] ?? false),
								'val_75' => ($campo['75'] ?? false),
								'val_100' => ($campo['100'] ?? false)
							]);

					}

				}

			}

			return response()->json($data, 200);
		} catch (Exception $error) {
			return response()->json([
				'error' => $error->getMessage()
			], 500);
    	}
	}


	public function copiarFicha() {
    	$edicoes = Edicao::all()->sortByDesc('ano');

		$niveisEdicao = Nivel::select('nivel.*')
			->join('nivel_edicao', 'nivel_id', '=', 'nivel.id')
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->get();

		// TODO: remover e busca no front os níveis de acordo com a edição
		$niveis = $niveisEdicao;

		return view('admin.fichas.copy', compact('niveisEdicao', 'niveis', 'edicoes'));
	}

	public function copiaFicha(Request $request) {

    	$data = $request->all();

//		$formulario = Formulario::where('tipo', '=', $data['tipo'])
//			->where('edicao_id', '=', $data['tipo']);

    	return $data;
	}
}
