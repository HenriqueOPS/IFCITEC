<?php

namespace App\Http\Controllers;

use App\Mensagem;
use App\Edicao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\MailBase;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailAllJob;
use Illuminate\Support\Facades\Queue;

class GerenMsgController extends Controller
{
    public function index()
    {
        return view('admin.gerenMsg.email');
    }

    public function fetchByType(string $tipo)
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
    }

    public function delete(int $id)
    {
        Mensagem::where('id', '=', $id)->delete();
    }
    public function enviar(Request $req)
{
    $conteudo = base64_decode($req->input('conteudo'));
    $funcoesEscolhidas = $req->input('funcoes');

    $teste = DB::table('funcao_pessoa')
    ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
    ->whereIn('funcao.funcao', $funcoesEscolhidas)
    ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
    ->where('pessoa.oculto', false)
    ->get();
    foreach ($teste as $item) {
        dispatch(new MailAllJob($conteudo, $item->email));
    }
}
}
