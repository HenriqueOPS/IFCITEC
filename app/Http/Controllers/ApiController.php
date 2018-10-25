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
    	$res = array();
    	$dados = DB::table('avaliacao')->select('projeto_id')->where('pessoa_id','=',$id)->get();
    	foreach($dados as $key => $val){
    		$dados[$key]->rows = DB::table('projeto')->select('titulo','nivel_id','id')->where('id','=',$dados[$key]->projeto_id)->get();
    	}
		return $dados;
	}

	public function camposAvaliacao($id) {
		$res = array();
		$niv = array();
		$niv = DB::table('projeto')->select('nivel_id')->where('id','=',$id)->get();
		if($niv[0]->nivel_id == "2"){
			$res = DB::table('categoria_avaliacao')->select('id','descricao', 'categoria_avaliacao', 'peso')->where('nivel_id','=', $niv[0]->nivel_id)->get();
			foreach($res as $key => $val){
				$res[$key]->rows = DB::table('campos_avaliacao')->select('campo','descricao','val_0','val_25','val_50','val_75','val_100')->where('categoria_id','=',$res[$key]->id)->get();
			}
			return $res;
		}else if($niv[0]->nivel_id == "3"){
			$res = DB::table('categoria_avaliacao')->select('id','descricao', 'categoria_avaliacao', 'peso')->where('nivel_id','=', $niv[0]->nivel_id)->get();
			foreach($res as $key => $val){
				$res[$key]->rows = DB::table('campos_avaliacao')->select('campo','descricao','val_0','val_25','val_50','val_75','val_100')->where('categoria_id','=',$res[$key]->id)->get();
			}
			return $res;
		}
	}

	public function salvaAvaliacao($id) {
		$cont = DB::table('dados_avaliacao')->select('projeto_id', 'pessoa_id')->where('pessoa_id', $_POST['idAva'])->where('projeto_id', $_POST['id'])->get();
		if($cont->count() != 0){
			DB::table('dados_avaliacao')->where('pessoa_id','=', $_POST['idAva'])->where('projeto_id','=', $_POST['id'])->update(['valor' => $_POST['nota']]);
			DB::table('avaliacao')->where('pessoa_id','=', $_POST['idAva'])->where('projeto_id','=', $_POST['id'])->update(['nota_final' => $_POST['nota'], 'observacao' => $_POST['observacoes'], 'avaliado' => 'true']);
		}
		else{
			DB::table('dados_avaliacao')->insert(['pessoa_id' => $_POST['idAva'], 'projeto_id' => $_POST['id'], 'valor' => $_POST['nota']]);
			DB::table('avaliacao')->insert(['pessoa_id' => $_POST['idAva'], 'projeto_id' => $_POST['id'], 'nota_final' => $_POST['nota'], 'observacao' => $_POST['observacoes'], 'avaliado' => 'true']);
		}
		return 'true';
	}


}
