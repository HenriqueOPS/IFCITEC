<?php

namespace App\Http\Controllers;

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

            return response()->json('ok', 200);
        }

        return response()->json('erro', 400);

    }

}
