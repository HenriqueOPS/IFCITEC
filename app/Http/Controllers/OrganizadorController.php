<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Edicao;
use App\Funcao;
use App\Projeto;
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
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('isOrganizacao');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $escolas = DB::table('escola')
        ->select('escola.id', 'nome_completo', 'nome_curto', 'email', 'telefone')
        ->orderBy('nome_curto', 'asc')->get();



		$projetos = DB::table('projeto')
            ->select('titulo', 'id')
            ->orderBy('titulo')
            ->where('edicao_id', Edicao::getEdicaoId())
            ->get()
            ->keyBy('id')
            ->toArray();
        $numeroProjetos = count($projetos);

		$autores = array();
		$orientadores = array();
		$coorientadores = array();

		//Participantes dos projetos
		if($projetos){
			$idAutor =  Funcao::where('funcao','Autor')->first();
			$idOrientador =  Funcao::where('funcao','Orientador')->first();
			$idCoorientador =  Funcao::where('funcao','Coorientador')->first();

			$ids = array_keys($projetos);

			$autores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')
				->whereIn('projeto_id', $ids)
				->where('funcao_id', $idAutor->id)
				->get()
				->toArray();

			$orientadores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')
				->whereIn('projeto_id', $ids)
				->where('funcao_id', $idOrientador->id)
				->get()
				->toArray();

			$coorientadores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')
				->whereIn('projeto_id', $ids)->where('funcao_id', $idCoorientador->id)
				->get()
				->toArray();
		}

        return view('organizacao.home', collect([
			'projetos' => $projetos,
			'autores' => $autores,
			'orientadores' => $orientadores,
			'coorientadores' => $coorientadores,
            'numeroProjetos' => $numeroProjetos
		]))->withEscolas($escolas);

    }

    protected function groupProjetosPorFuncao($projetos) {
        $funcoes = Funcao::all();
        $projetosAgrupados = array();
        foreach ($funcoes as $funcao) {
            foreach ($projetos as $projeto) {
                if ($projeto->pivot->funcao_id === $funcao->id) {
                    $projetosAgrupados[$funcao->funcao][] = $projeto;
                }
            }
        }
        return collect($projetosAgrupados);
    }

    protected function groupProjetosPorSituacao($projetos){
        $projetosAgrupados = array();
        foreach ($projetos as $projeto) {
            $situacao = 0;
            switch ($projeto->getStatus()){
                case "Não Revisado":
                    $situacao = 0;
                    break;
                case "Homologado":
                    $situacao = 1;
                    break;
                case "Homologado com Revisão":
                    $situacao = 2;
                    break;
                case "Reprovado":
                    $situacao = 3;
                    break;
                case "Avaliado":
                    $situacao = 5;
                    break;
                case "Não Compareceu":
                    $situacao = 6;
                    break;
            }
            $projetosAgrupados[$situacao][] = $projeto;
        }
        return (collect($projetosAgrupados));
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

    public function relatorios(){

        return view('organizacao.relatorios');
    }

    public function presenca(){

        return view('organizacao.presenca');
    }

}
