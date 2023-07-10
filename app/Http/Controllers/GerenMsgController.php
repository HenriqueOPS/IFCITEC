<?php

namespace App\Http\Controllers;

use App\Mensagem;
use App\Edicao;
use App\Escola;
use App\Pessoa;
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
        $funcoesgerais = $req->input('funcoesgerais');
        $funcoesedicao = $req->input('funcoesedicao');
        $geral = collect([]);
        $edicao = collect([]);
        
        if (!is_null($funcoesgerais)) {
            if (in_array('Participantes', $funcoesgerais)) {
                $participantesEmails = Pessoa::pluck('email')->toArray();
                $geral = $geral->concat($participantesEmails);
            }
            
            if (in_array('Escolas', $funcoesgerais)) {
                $escolasEmails = Escola::pluck('email')->toArray();
                $geral = $geral->concat($escolasEmails);
            }
            
            if (in_array('Homologadores', $funcoesgerais)) {
                $homologadoresEmails = DB::table('funcao_pessoa')
                ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                ->whereIn('funcao.funcao', ['Homologador'])
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->where('pessoa.oculto', false)
                ->select('pessoa.email')
                ->distinct()
                ->pluck('email');
                $geral = $geral->concat($homologadoresEmails);
            }
            
            if (in_array('Avaliadores', $funcoesgerais)) {
                $avaliadoresEmails = DB::table('funcao_pessoa')
                ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                ->whereIn('funcao.funcao', ['Avaliador'])
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->where('pessoa.oculto', false)
                ->select('pessoa.email')
                ->distinct()
                ->pluck('email');
                $geral = $geral->concat($avaliadoresEmails);
            }
        }
        
        if (!is_null($funcoesedicao)) {
            $edicao = DB::table('funcao_pessoa')
                ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                ->whereIn('funcao.funcao', $funcoesedicao)
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->where('edicao_id', '=', Edicao::getEdicaoId())
                ->where('pessoa.oculto', false)
                ->select('pessoa.email')
                ->distinct()
                ->pluck('email');
        }
        
        $emails = $geral->concat($edicao)->unique();
        
        foreach ($emails as $email) {
            dispatch(new MailAllJob($conteudo, $email));
        }
    }
}
