<?php

namespace App\Http\Controllers;

use App\Mensagem;
use Illuminate\Http\Request;

class GerenMsgController extends Controller
{
    public function index() {
        return view('admin.gerenMsg.email');
    }

    public function fetch(string $tipo) {
        $mensagens = Mensagem::where('tipo', '=', $tipo)->get();

        return response($mensagens);
    }

    public function save(string $nome, string $conteudo, string $tipo) {
        $mensagem = Mensagem::where([
            'nome', '=', $nome,
            'tipo', '=', $nome
        ])->first();
            
        return response($mensagem);
    }

    public function delete(int $id) {
        Mensagem::where('id', '=', $id)->delete();
    }
}
