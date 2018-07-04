<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

	public function login(Request $req, PeriodosController $p) {

		$data = $req->all();
		$res = array();

		$getPessoa = Pessoa::where('email', $data['email'])->get();

		if($getPessoa) {
			if (password_verify($data['senha'], $getPessoa[0]->senha)) {

				$funcoes = DB::table('funcao_pessoa')->select('funcao_id')
					->where('pessoa_id','=', $getPessoa[0]->id)->get();

				dd($funcoes);

				$res['id'] = $getPessoa[0]->id;
				$res['nome'] = $getPessoa[0]->nome;
				$res['funcao'] = '';

				return response()->json($res);

			}else{
				$res['result'] = 0;
				$res['msg'] = 'Email ou senha invalidos';
			}
		}else{
			$res['result'] = 0;
			$res['msg'] = 'Email ou senha invalidos';
		}

		return response()->json($res);

	}

	public function registraPresenca(Request $req) {


		return 'registra-presenca';


	}

	public function projetosAvaliacao($id) {

		return 'projetos-avaliacao '.$id;


	}

	public function camposAvaliacao($id) {
		return 'campos-avaliacao '.$id;
	}

	public function salvaAvaliacao($id) {
		return 'salva-avaliacao '.$id;
	}

}
