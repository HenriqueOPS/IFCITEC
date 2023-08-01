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
        return response()->json(['mensagem' => 'Emails Salvo com Sucesso']);
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
                $participantesEmails = Pessoa::where("pessoa.oculto",'=',false)->pluck('email')->toArray();
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
                ->whereIn('funcao.funcao', ['Administrador'])
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->where('edicao_id', '=', Edicao::getEdicaoId())
                ->orWhere('pessoa_id','=',2227)
                ->orWhere('pessoa_id','=',87)
                ->where('pessoa.oculto', false)
                ->select('pessoa.email')
                ->distinct()
                ->pluck('email');
        }
        
        $emails = $geral->concat($edicao)->unique();
        $contador = DB::table('emails_enviados')->where('email','=','contador')->get();
        if (!$contador) {
            DB::table('emails_enviados')->insert([
                'email' => 'contador',
                'horario_envio' => \Carbon\Carbon::now(),
                'status' => true,
                'lote' => 1,
            ]);
        }
        foreach ($emails as $email) {
            dispatch(new MailAllJob($conteudo, $email));
            DB::table('emails_enviados')->insert([
                'email' => $email,
                'horario_envio' => \Carbon\Carbon::now(),
                'status' => true,
                'lote' => $contador[0]->lote,
            ]);
        }
        $lote =  $contador[0]->lote;
        $contador[0]->lote += 1;
        DB::table('emails_enviados')->where('email', '=', 'contador')->update(['lote' => $contador[0]->lote]);
        return response()->json(['mensagem' => 'Emails enviados com sucesso este é o Lote Numero ' . $lote]);
    }
    public function tabela()
    {
          $emailsEnviados = DB::table('emails_enviados')
            ->where('email', '!=', 'contador')
            ->where('status', true)
            ->orderBy('lote')
            ->get();

        // Buscar os lotes disponíveis para filtrar na view
        $lotes = DB::table('emails_enviados')
            ->select('lote')
            ->where('email', '!=', 'contador')
            ->where('status', true)
            ->groupBy('lote')
            ->pluck('lote');

        return view('admin.gerenMsg.emails_enviados', compact('emailsEnviados', 'lotes'));
   }
    
}
