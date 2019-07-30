<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Edicao;
use App\Funcao;
use App\Projeto;
use App\Pessoa;
use App\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrganizadorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

         $escolas = DB::table('escola')
        	->select('escola.id', 'nome_completo', 'nome_curto', 'email', 'telefone')
        	->orderBy('nome_curto', 'asc')
			 ->get();

        return view('organizacao.home')->withEscolas($escolas);
    }

    public function projetos() {

        $projetos = Projeto::select('titulo', 'id', 'situacao_id')
            ->orderBy('titulo')
            ->where('edicao_id', Edicao::getEdicaoId())
            ->get()
            ->keyBy('id');

        $numeroProjetos = count($projetos);
        $autores = array();
        $orientadores = array();
        $coorientadores = array();

        //Participantes dos projetos
        if ($projetos) {
            $idAutor = Funcao::where('funcao', 'Autor')->first();
            $idOrientador = Funcao::where('funcao', 'Orientador')->first();
            $idCoorientador = Funcao::where('funcao', 'Coorientador')->first();

            $arrayIDs = $projetos;
            $ids = array_keys($arrayIDs->toArray());

            $autores = DB::table('escola_funcao_pessoa_projeto')
                ->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
                ->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
                ->whereIn('projeto_id', $ids)
                ->where('funcao_id', $idAutor->id)
                ->get()
                ->toArray();

            $orientadores = DB::table('escola_funcao_pessoa_projeto')
                ->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
                ->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
                ->whereIn('projeto_id', $ids)
                ->where('funcao_id', $idOrientador->id)
                ->get()
                ->toArray();

            $coorientadores = DB::table('escola_funcao_pessoa_projeto')
                ->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
                ->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
                ->whereIn('projeto_id', $ids)->where('funcao_id', $idCoorientador->id)
                ->get()
                ->toArray();
        }

        return view('organizacao.projetos', collect([
            'autores' => $autores,
            'orientadores' => $orientadores,
            'coorientadores' => $coorientadores,
            'numeroProjetos' => $numeroProjetos
        ]))->withProjetos($projetos);

    }

    public function presenca() {
        return view('organizacao.presenca');
    }

}
