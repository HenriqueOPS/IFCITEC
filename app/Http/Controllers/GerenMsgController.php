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
        // Usei base64 pro laravel n remover as tags html do request
        $conteudo = base64_decode($req->all()['conteudo']);

        DB::table('mensagem')
            ->where('id', '=', $req->all()['id'])
            ->limit(1)
            ->update(['conteudo' => $conteudo]);

        return response()->json([
            $conteudo
        ]);
    }

    public function delete(int $id)
    {
        Mensagem::where('id', '=', $id)->delete();
    }
}
