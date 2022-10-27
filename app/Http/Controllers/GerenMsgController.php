<?php

namespace App\Http\Controllers;

use App\Mensagem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GerenMsgController extends Controller
{
    public function index()
    {
        return view('admin.gerenMsg.email');
    }

    public function fetch(string $tipo)
    {
        $mensagens = Mensagem::where('tipo', '=', $tipo)->get();

        return response($mensagens);
    }

    public function create(string $nome, string $tipo)
    {
        DB::table('mensagem')->insert([
            'nome' => $nome,
            'tipo' => $tipo
        ]);
    }

    public function save(Request $req)
    {
        DB::table('mensagem')
            ->where('id', '=', $req->query('id'))
            ->limit(1)
            ->update(['conteudo' => $req->query('conteudo')]);
    }

    public function delete(int $id)
    {
        Mensagem::where('id', '=', $id)->delete();
    }
}
