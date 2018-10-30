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

    public function presenca(){

        return view('organizacao.presenca');
    }

    public function relatoriosEdicao(){
        $edicoes = Edicao::all();
        return view('organizacao.relatoriosEdicao')->withEdicoes($edicoes);
    }

    public function relatoriosEscolheEdicao(Request $req){
        $data = $req->all();
        $edicao = $data['edicao'];
        return redirect()->route('organizacao.relatorios', ['edicao' => $edicao]);
    }

    public function relatorios($edicao){
        return view('organizacao.relatorios', array('edicao' => $edicao));
    }

    public function usuarios(){
        $usuarios = Pessoa::orderBy('nome')->get();

        return view('organizacao.usuarios')->withUsuarios($usuarios);
    }

    public function excluiUsuario($id, $s)
    {
        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            Pessoa::find($id)->delete();
            return 'true';
        }

        return 'false';
    }

    public function editarFuncaoUsuario($id)
    {
        $usuario = Pessoa::find($id);
        $funcoes = Funcao::all();
        $tarefas = Tarefa::orderBy('tarefa')->get();

        return view('organizacao.usuario.editarFuncao')
            ->withUsuario($usuario)
            ->withFuncoes($funcoes)
            ->withTarefas($tarefas);
    }

    public function editaFuncaoUsuario(Request $req, $id)
    {
        $data = $req->all();
        $funcoes = DB::table('funcao_pessoa')
            ->select('funcao_id')
            ->where('pessoa_id', $id)
            ->get()
            ->keyBy('funcao_id')
            ->toArray();

        $usuario = Pessoa::find($id);

        if(isset($data['tarefa'])){
            if ($usuario->tarefas->first() != null) {
                if($usuario->tarefas->first()->id != $data['tarefa']){
                    DB::table('pessoa_tarefa')->where('pessoa_id', $id)->update([
                        'tarefa_id' => $data['tarefa']]);
                }
            }
            else {
                DB::table('pessoa_tarefa')->insert(
                ['edicao_id' => Edicao::getEdicaoId(),
                    'tarefa_id' => $data['tarefa'],
                    'pessoa_id' => $id,
                ]
            );
            }
        }
        
        if (!empty($funcoes)) {
            $funcaoId = array_keys($funcoes);
            foreach ($funcoes as $funcao) {
                if($funcao->funcao_id == Funcao::select(['id'])->where('funcao', 'Voluntário')->first()->id){
                    if (!isset($data['funcao']) || (!in_array($funcao->funcao_id, $data['funcao']))) {
                        DB::table('pessoa_tarefa')->where('edicao_id', Edicao::getEdicaoId())->where('pessoa_id', $id)->delete();
                    }
                }
                if ($funcao->funcao_id != Funcao::select(['id'])->where('funcao', 'Autor')->first()->id && $funcao->funcao_id != Funcao::select(['id'])->where('funcao', 'Orientador')->first()->id && $funcao->funcao_id != Funcao::select(['id'])->where('funcao', 'Coorientador')->first()->id && $funcao->funcao_id != Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id && $funcao->funcao_id != Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id) {    
                    if (!isset($data['funcao']) || (!in_array($funcao->funcao_id, $data['funcao']))) {
                        DB::table('funcao_pessoa')->where('funcao_id', $funcao->funcao_id)->where('pessoa_id', $id)->delete();
                    }
                }
            }

            if (isset($data['funcao'])) {
                foreach ($data['funcao'] as $funcao) {
                    if (!in_array($funcao, $funcaoId)) {
                        DB::table('funcao_pessoa')->insert([
                            'funcao_id' => $funcao,
                            'pessoa_id' => $id,
                            'edicao_id' => Edicao::getEdicaoId(),
                            'homologado' => TRUE
                        ]);
                    }
                }
            }
        } else {
            foreach ($data['funcao'] as $funcao) {
                DB::table('funcao_pessoa')->insert([
                    'funcao_id' => $funcao,
                    'pessoa_id' => $id,
                    'edicao_id' => Edicao::getEdicaoId(),
                    'homologado' => TRUE
                ]);
            }
        }
        $usuarios = Pessoa::orderBy('nome')->get();

        //$usuario = Pessoa::find($id);
        $tarefas = Tarefa::orderBy('tarefa')->get();
        $funcoes = Funcao::all();
        return view('organizacao.usuarios')
            ->withUsuarios($usuarios)
            ->withFuncoes($funcoes)
            ->withTarefas($tarefas);
    }

    public function editarUsuario($id) {
        $dados = Pessoa::find($id);
        $dados->dt_nascimento = implode("/", array_reverse(explode("-", $dados->dt_nascimento)));
        return view('organizacao.usuario.editarCadastro', compact('dados'));
    }

    public function editaUsuario(Request $req, $id) {
        $data = $req->all();
        $data['dt_nascimento'] = implode('-',array_reverse(explode('/', $data['dt_nascimento'])));
        Pessoa::find($id)->update($data);
        return redirect()->route('organizacao.usuarios');

    }

}
