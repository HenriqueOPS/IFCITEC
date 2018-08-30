<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;
use App\Presenca;
use Illuminate\Support\Facades\DB;
use DateTime;

class ApiController extends Controller
{

	public function login(Request $req, PeriodosController $p) {
		$data = $req->all();
		$res = array();
		$getPessoa = Pessoa::where('email', $data['email'])->get();

		if($getPessoa->count()) {
			if (password_verify($data['senha'], $getPessoa[0]->senha)) {

				$funcoes = DB::table('funcao_pessoa')->select('funcao_id')->where('pessoa_id','=', $getPessoa[0]->id)->get();
				$funcao = DB::table('funcao')->select('funcao')->where('id','=',$funcoes[0]->funcao_id)->get();

				$res['id'] = $getPessoa[0]->id;
				$res['nome'] = $getPessoa[0]->nome;
				$res['funcao'] = $funcao[0]->funcao;

				return response()->json($res);

			}else{
				$res['result'] = 0;
				$res['msg'] = 'EMAIL OU SENHA INVÁLIDOS!!!';
			}
		}else{
			$res['result'] = 0;
			$res['msg'] = 'EMAIL OU SENHA INVÁLIDOS!!!';
		}

		return response()->json($res);

	}

	public function registraPresenca(Request $req) {
		$dados = $req->all();
		$res = array();
		$data = Pessoa::where('id', $dados['codigo'])->get();
		if($data->count()){
			$results = Presenca::where('id_pessoa',$dados['codigo'])->get();
			if($results->count()){
				$params = [date('Y-m-d H:i:s'), $dados['codigo']];
				\DB::update('UPDATE presenca SET updated_at = ? WHERE id_pessoa = ?', $params);
				$nome = array();
				$sql = Pessoa::where('id', $dados['codigo'])->get();
				$nome['nome'] = $sql[0]->nome;
				$res['msg'] = "HORÁRIO DE SAÍDA DO PARTICIPANTE {$nome['nome']} REGISTRADO!";
				return response()->json($res);
			}else{
				Presenca::insert(['id_pessoa' => $dados['codigo'], 'created_at' => date('Y-m-d H:i:s')]);
				$nome = array();
				$sql = Pessoa::where('id', $dados['codigo'])->get();
				$nome['nome'] = $sql[0]->nome;
				$res['msg'] = "#{$dados['codigo']} {$nome['nome']}: PRESENÇA REGISTRADA!";
				return response()->json($res);
			}
		}else{
			$res['msg'] = "CÓDIGO #{$dados['codigo']} NÃO PODE SER LIDO!";
			return response()->json($res);
		}
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
