<?php

namespace App\Http\Controllers;

use App\Projeto;
use Illuminate\Http\Request;
use App\Pessoa;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

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

}
