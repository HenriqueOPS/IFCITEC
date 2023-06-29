<?php

namespace App\Http\Controllers;

use App\Mensagem;
use App\Edicao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\MailBase;
use Illuminate\Support\Facades\Mail;

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
        ->get()
        ->toArray();

    $destinatariosPorLote = 100; // Defina o número máximo de destinatários por lote

    $batches = array_chunk($teste, $destinatariosPorLote); // Divide os destinatários em lotes

    if (is_array($batches)) {
        foreach ($batches as $batch) {
            foreach ($batch as $item) {
                $email = new MailBase($conteudo);
                Mail::to($item->email)->queue($email);
            }
        }
    }
}
}
