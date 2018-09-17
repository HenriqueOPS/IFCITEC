<?php

namespace App\Http\Controllers;

use App\Projeto;
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



    public function salvaAvaliacao(Request $req) {

        if($req->header('authorization') == 'bmFvbWVqdWxndWU='){

            $data = $req->all();

            DB::table('avaliacao')
                ->where('projeto_id','=',$data['idProjeto'])
                ->where('pessoa_id','=',$data['idPessoa'])
                ->update([
                    'nota_final' => $data['notaFinal'],
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
                ->where('projeto_id','=',$data['idProjeto'])
                ->where('avaliado','=',false)
                ->get();

            if($cont->count() == 0)
                Projeto::find($data['idProjeto'])->update(['situacao_id' => 5]);

            return response()->json('ok', 200);
        }

        return response()->json('erro', 400);

    }

    public function salvaHomologacao(Request $req) {

        if($req->header('authorization') == 'bmFvbWVqdWxndWU='){

            $data = $req->all();

            DB::table('revisao')
                ->where('projeto_id','=',$data['idProjeto'])
                ->where('pessoa_id','=',$data['idPessoa'])
                ->update([
                    'nota_final' => $data['notaFinal'],
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


            return response()->json('ok', 200);
        }

        return response()->json('erro', 400);

    }


    public function presenca(Request $req) {

        $data = $req->all();

        if(is_numeric($data['id'])){

            $results = Presenca::where('id_pessoa', $data['id'])->get();

            if($results->count())
                return response()->json('warning', 200);

            Presenca::insert(['id_pessoa' => $data['id'], 'created_at' => date('Y-m-d H:i:s')]);
            return response()->json('ok', 200);
        }

        return response()->json('erro', 400);

    }

}
