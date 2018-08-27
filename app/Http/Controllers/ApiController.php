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





            return response()->json('ok', 200);
        }

        return response()->json('erro', 400);

    }

}
