<?php

namespace App\Http\Controllers;
use App\Mensagem;
use App\AreaConhecimento;
use App\Edicao;
use App\Endereco;
use App\Enums\EnumFuncaoPessoa;
use App\Enums\EnumSituacaoProjeto;
use App\Escola;
use App\Brindes;
use App\Empresa;
use App\Funcao;
use App\Http\Requests\AreaRequest;
use App\Http\Requests\NivelRequest;
use App\Nivel;
use App\Pessoa;
use App\Projeto;
use App\Situacao;
use App\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;



class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edicoes = Edicao::all(['id', 'ano',
            'feira_abertura', 'feira_fechamento'])->sortByDesc('ano');

        $comissao = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('comissao_edicao', function ($join) {
                $join->on('comissao_edicao.pessoa_id', '=', 'pessoa.id');
                $join->where('comissao_edicao.edicao_id', '=', Edicao::getEdicaoId());
            })
            ->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId())
            ->whereRaw('(funcao_pessoa.funcao_id = 3 or funcao_pessoa.funcao_id = 4)')
            ->select('comissao_edicao.id', 'funcao_pessoa.homologado', 'funcao_pessoa.funcao_id',
                'pessoa.nome', 'pessoa.instituicao', 'pessoa.titulacao')
            ->orderBy('funcao_pessoa.homologado')
            ->orderBy('pessoa.nome')
            ->get()
            ->toArray();

        return view('admin.home', collect(['edicoes' => $edicoes, 'comissao' => $comissao]));

    }

    public function dashboardPage()
    {
        return view('admin.dashboard');
    }

    public function dashboard()
    {
        $response = [];

        $response['projetos']['avaliados'] = Projeto::where('edicao_id', '=', Edicao::getEdicaoId())
            ->where('situacao_id', '=', 5)
            ->count();

        $response['projetos']['naoAvaliados'] = Projeto::where('edicao_id', '=', Edicao::getEdicaoId())
            ->where('situacao_id', '=', 4)
            ->count();

        // total de projetos (avaliados + não avaliados)
        $response['projetos']['numProjetos'] = $response['projetos']['avaliados'] + $response['projetos']['naoAvaliados'];

        $subQuery = DB::table('avaliacao')
            ->select(DB::raw('count(*)'))
            ->where('avaliacao.projeto_id', '=', DB::raw('projeto.id'))
            ->where('avaliacao.avaliado', '=', DB::raw('true'))
            ->toSql();

        // projetos com apenas uma avalição até o momento
        $response['projetos']['umaAvalicao'] = Projeto::select('projeto.id')
            ->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
            ->where(DB::raw(1), '=', DB::raw('(' . $subQuery . ')'))
            ->where('situacao_id', '=', 4)
            ->count();

        $response['avaliadores']['numAvaliadores'] = DB::table('funcao_pessoa')
            ->where('edicao_id', '=', Edicao::getEdicaoId())
            ->where('funcao_id', '=', 3)
            ->count();

        $response['avaliadores']['presentes'] = DB::table('funcao_pessoa')
            ->join('presenca', 'funcao_pessoa.pessoa_id', '=', 'presenca.id_pessoa')
            ->where('presenca.edicao_id', '=', Edicao::getEdicaoId())
            ->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId())
            ->where('funcao_pessoa.funcao_id', '=', 3)
            ->count();

        $response['avaliadores']['naoPresentes'] = $response['avaliadores']['numAvaliadores'] - $response['avaliadores']['presentes'];

        return response()->json($response);
    }

    public function dashboardNaoAvaliados() {
        $response = [];
        $response['projetosNaoAvaliados'] = Projeto::select('titulo')
            ->orderBy('titulo')
            ->where('edicao_id', Edicao::getEdicaoId())
            ->where('situacao_id', EnumSituacaoProjeto::getValue('NaoAvaliado'))
            ->get();
        
        return response()->json($response);
    }

    public function dashboardAvaliadoresNaoPresentes() {
        $response = [];

        $presentes = DB::table('presenca')->select('presenca.id_pessoa')->get();
        $presentesArr = [];
    
        foreach($presentes as $pessoa) {
            array_push($presentesArr, $pessoa->id_pessoa);
        }

        $response['avaliadoresNaoPresentes'] = DB::table('pessoa')
            ->select('pessoa.id', 'pessoa.nome')
            ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->whereNotIn('pessoa.id', $presentesArr)
            ->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId())
            ->where('funcao_pessoa.funcao_id', '=', 3)
            ->get();
        
        return response()->json($response);
    }

    public function projetos()
    {

        $projetos = Projeto::select('titulo', 'id', 'situacao_id','presenca')
            ->orderBy('titulo')
            ->where('edicao_id', Edicao::getEdicaoId())
            ->get()
            ->keyBy('id');
        $numprojshomologados = $projetos->where('situacao_id', 3)->count();
        $periodoAvaliacao = Edicao::consultaPeriodo('Avaliação');

        return view('admin.projeto.home', compact('periodoAvaliacao','numprojshomologados'))->withProjetos($projetos);
    }

    public function escolas()
    {
        $escolas = Escola::orderBy('nome_curto')->get();

        return view('admin.escola.home', collect(['escolas' => $escolas]));
    }

    public function areasPorNiveis()
    {
        $areas = AreaConhecimento::all(['id', 'area_conhecimento', 'descricao', 'nivel_id'])
        ->groupBy('nivel_id');
        $medio = $areas[2];
        $fundamental = $areas[3];
        $niveis = Nivel::orderBy('nivel')->get();

        return view('admin.area.home')->withMedio($medio)->withFundamental($fundamental)->withNiveis($niveis);
    }

    public function tarefas()
    {
        $tarefas = DB::table('tarefa')->orderBy('tarefa')->get()->toArray();

        return view('admin.tarefa.home', collect(['tarefas' => $tarefas]));
    }

    public function usuarios()
    {
        $usuarios = Pessoa::orderBy('nome')->get();

        return view('admin.usuario.home')->withUsuarios($usuarios);
    }

    public function notaRevisao($id)
    {
        $projeto = Projeto::find($id);
        $situacoes = Situacao::all();

        $revisao = DB::table('revisao')->join('pessoa', 'revisao.pessoa_id', '=', 'pessoa.id')
            ->select('revisao.pessoa_id', 'revisao.observacao', 'revisao.nota_final', 'pessoa.nome')
            ->where('revisao.projeto_id', $id)
            ->get()->toArray();

        return view('admin.notaRevisao', array('projeto' => $projeto, 'situacoes' => $situacoes, 'revisao' => $revisao));
    }

    public function mudaNotaRevisao(Request $req)
    {
        $data = $req->all();

        Projeto::where('id', $data['projeto'])
            ->update(['situacao_id' => $data['situacao'],
            ]);
        DB::table('revisao')
            ->where('projeto_id', $data['projeto'])
            ->where('pessoa_id', $data['rev1'])
            ->update([
                'nota_final' => $data['nota1'],
                'observacao' => $data['obs1'],
            ]);

        DB::table('revisao')
            ->where('projeto_id', $data['projeto'])
            ->where('pessoa_id', $data['rev2'])
            ->update([
                'nota_final' => $data['nota2'],
                'observacao' => $data['obs2'],
            ]);

        DB::table('projeto')
            ->where('id', $data['projeto'])
            ->update([
                'nota_revisao' => (($data['nota1'] + $data['nota2']) / 2),
            ]);

        $projeto = Projeto::find($data['projeto']);
        $situacoes = Situacao::all();

        $revisao = DB::table('revisao')->join('pessoa', 'revisao.pessoa_id', '=', 'pessoa.id')
            ->select('revisao.pessoa_id', 'revisao.observacao', 'revisao.nota_final', 'pessoa.nome')
            ->where('revisao.projeto_id', $data['projeto'])
            ->get()->toArray();

        return view(
            'admin.notaRevisao',
            [
                'projeto' => $projeto,
                'situacoes' => $situacoes,
                'revisao' => $revisao,
            ]
        );
    }

    public function notaAvaliacao($id)
    {
        $projeto = Projeto::find($id);
        $situacoes = Situacao::all();

        $avaliacao = DB::table('avaliacao')->join('pessoa', 'avaliacao.pessoa_id', '=', 'pessoa.id')
            ->select('avaliacao.pessoa_id', 'avaliacao.observacao', 'avaliacao.nota_final', 'pessoa.nome')
            ->where('avaliacao.projeto_id', $id)
            ->get()->toArray();

        return view('admin.notaAvaliacao', array('projeto' => $projeto, 'situacoes' => $situacoes, 'avaliacao' => $avaliacao));
    }

    public function mudaNotaAvaliacao(Request $req)
    {
        $data = $req->all();

        Projeto::where('id', $data['projeto'])
            ->update(['situacao_id' => $data['situacao'],
            ]);
        DB::table('avaliacao')->where('projeto_id', $data['projeto'])
            ->where('pessoa_id', $data['ava1'])
            ->update(['nota_final' => $data['nota1'], 'observacao' => $data['obs1']]);

        DB::table('avaliacao')->where('projeto_id', $data['projeto'])
            ->where('pessoa_id', $data['ava2'])
            ->update(['nota_final' => $data['nota2'], 'observacao' => $data['obs2']]);

        DB::table('projeto')->where('id', $data['projeto'])
            ->update(['nota_avaliacao' => ($data['nota1'] + $data['nota2']) / 2]);

        $projeto = Projeto::find($data['projeto']);
        $situacoes = Situacao::all();

        $avaliacao = DB::table('avaliacao')->join('pessoa', 'avaliacao.pessoa_id', '=', 'pessoa.id')
            ->select('avaliacao.pessoa_id', 'avaliacao.observacao', 'avaliacao.nota_final', 'pessoa.nome')
            ->where('avaliacao.projeto_id', $data['projeto'])
            ->get()->toArray();

        return view('admin.notaAvaliacao', array('projeto' => $projeto, 'situacoes' => $situacoes, 'avaliacao' => $avaliacao));
    }

    public function comissao()
    {

        $comissao = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('comissao_edicao', function ($join) {
                $join->on('comissao_edicao.pessoa_id', '=', 'pessoa.id');
                $join->where('comissao_edicao.edicao_id', '=', Edicao::getEdicaoId());
            })
            ->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId())
            ->whereRaw('(funcao_pessoa.funcao_id = 3 or funcao_pessoa.funcao_id = 4)')
            ->select('comissao_edicao.id', 'funcao_pessoa.homologado', 'funcao_pessoa.funcao_id',
                'pessoa.nome', 'pessoa.instituicao', 'pessoa.titulacao')
            ->orderByDesc('funcao_pessoa.homologado')
            ->orderBy('pessoa.nome', 'asc')
            ->get()
            ->toArray();
        $voluntarios = DB::table('funcao_pessoa')
        ->where('funcao_id',9)
        ->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
        ->join('pessoa','pessoa.id','funcao_pessoa.pessoa_id')
        ->join('voluntarios','voluntarios.id','funcao_pessoa.pessoa_id')
        ->where('voluntarios.edicao_id',Edicao::getEdicaoId())
        ->select('nome','homologado','ano','turma','curso','pessoa_id')
        ->orderBy('homologado', 'desc')
        ->orderBy('nome')
        ->get();
        $funcoesvoluntarios = DB::table('tarefa')->get();
        $funcoesvoluntarios = DB::table('tarefa')->get();

        return view('admin.comissao.home', compact('comissao', 'voluntarios', 'funcoesvoluntarios'));
        }

    public function relatorios($edicao)
    {
        return view('admin.relatorios.homeEdicao', array('edicao' => $edicao));
    }

    public function relatoriosEdicao()
    {
        $edicoes = Edicao::all()->sortByDesc('ano');

        return view('admin.relatorios.home')->withEdicoes($edicoes);
    }

    public function relatoriosEscolheEdicao(Request $req)
    {
        $data = $req->all();
        $edicao = $data['edicao'];

        return redirect()->route('administrador.relatorios', ['edicao' => $edicao]);
    }

    public function homologarProjetos()
    {

    }

    public function dadosNivel($id)
    { //Ajax
        return Nivel::find($id);
    }

    public function cadastroNivel()
    {
        return view('admin.nivel.create');
    }

    public function cadastraNivel(NivelRequest $req)
    {
        $data = $req->all();

        Nivel::create([
            'nivel' => $data['nivel'],
            'descricao' => $data['descricao'],
            'max_ch' => $data['max_ch'],
            'min_ch' => $data['min_ch'],
            'palavras' => $data['palavras'],
        ]);

        return redirect()->route('administrador.niveis');
    }

    public function editarNivel($id)
    {
        $dados = Nivel::find($id);
        return view('admin.nivel.edit', array('dados' => $dados));

    }

    public function editaNivel(NivelRequest $req)
    {

        $data = $req->all();
        $id = $data['id_nivel'];

        Nivel::where('id', $id)
            ->update(['nivel' => $data['nivel'],
                'max_ch' => $data['max_ch'],
                'min_ch' => $data['min_ch'],
                'descricao' => $data['descricao'],
                'palavras' => $data['palavras'],
            ]);

        return redirect()->route('administrador.areas');
    }

    public function excluiNivel($id, $s)
    {

        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            Nivel::find($id)->delete();

            return 'true';
        }

        return 'false';
    }

    public function dadosArea($id)
    { //Ajax

        $dados = AreaConhecimento::find($id);
        $data = Nivel::find($dados->nivel_id)->nivel;

        return compact('dados', 'data');
    }

    public function cadastroArea()
    {
        $niveis = DB::table('nivel')->select('id', 'nivel')->get();

        return view('admin.area.create', array('niveis' => $niveis));
    }

    public function cadastraArea(AreaRequest $req)
    {
        $data = $req->all();

        AreaConhecimento::create([
            'nivel_id' => $data['nivel_id'],
            'area_conhecimento' => $data['area_conhecimento'],
            'descricao' => $data['descricao'],
        ]);

        return redirect()->route('administrador.areas');

    }

    public function editarArea($id)
    {
        $niveis = DB::table('nivel')->select('id', 'nivel')->get();
        $dados = AreaConhecimento::find($id);

        return view('admin.area.edit', array('niveis' => $niveis), compact('dados'));
    }

    public function editaArea(AreaRequest $req)
    {
        $data = $req->all();
        $id = $data['id_area'];

        AreaConhecimento::where('id', $id)
            ->update(['nivel_id' => $data['nivel_id'],
                'area_conhecimento' => $data['area_conhecimento'],
                'descricao' => $data['descricao'],
            ]);

        return redirect()->route('administrador.areas');
    }

    public function excluiArea($id, $s)
    {
        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            AreaConhecimento::find($id)->delete();
            return 'true';
        }

        return 'false';
    }

    public function dadosEscola($id)
    { //Ajax

        $dados = Escola::find($id);

        if ($dados['endereco_id']) {
            $data = Endereco::find($dados['endereco_id']);
        }

        return compact('dados', 'data');
    }

    public function editarEscola($id)
    {

        $data = '';
        $dados = Escola::find($id);

        if ($dados['endereco_id']) {
            $data = Endereco::find($dados['endereco_id']);
        }

        return view('admin.escola.edit', compact('dados', 'data'));

    }

    public function editaEscola(Request $req)
    {

        $data = $req->all();

        $id_escola = $data['id_escola'];
        $id_endereco = $data['id_endereco'];

        if ($id_endereco != 0) {

            Endereco::where('id', $id_endereco)
                ->update(['cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero'],
                ]);

        } else {

            $id_endereco = Endereco::create(['cep' => $data['cep'],
                'endereco' => $data['endereco'],
                'bairro' => $data['bairro'],
                'municipio' => $data['municipio'],
                'uf' => $data['uf'],
                'numero' => $data['numero'],
            ]);

            $id_endereco = $id_endereco['id'];

        }

        Escola::where('id', $id_escola)
            ->update(['nome_completo' => $data['nome_completo'],
                'nome_curto' => $data['nome_curto'],
                'email' => $data['email'],
                'telefone' => $data['telefone'],
                'endereco_id' => $id_endereco,
                'publica' => $data['publica']
            ]);

        return redirect()->route('administrador.escolas');
    }

    public function cadastroEscola()
    {
        return view('admin.escola.create');
    }

    public function cadastraEscola(Request $req)
    {
        $data = $req->all();
        $data['publica'] = $req->has('publica') ?? true;

        $idEndereco = Endereco::create([
            'cep' => $data['cep'],
            'endereco' => $data['endereco'],
            'bairro' => $data['bairro'],
            'municipio' => $data['municipio'],
            'uf' => $data['uf'],
            'numero' => $data['numero'],
        ]);

        Escola::create([
            'nome_completo' => $data['nome_completo'],
            'nome_curto' => $data['nome_curto'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'endereco_id' => $idEndereco['original']['id'],
            'publica' => $data['publica'],
        ]);

        return redirect()->route('administrador.escolas');
    }

    public function excluiEscola($id, $s)
    {

        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            Escola::find($id)->delete();

            return 'true';
        } else {
            return 'password-problem';
        }

    }

    public function cadastroTarefa()
    {
        return view('admin.tarefa.create');
    }

    public function cadastraTarefa(Request $req)
    {
        $data = $req->all();

        Tarefa::create([
            'tarefa' => $data['tarefa'],
            'descricao' => $data['descricao'],
        ]);

        return redirect()->route('administrador.tarefas');
    }

    public function editarTarefa($id)
    {
        $dados = Tarefa::find($id);
        return view('admin.tarefa.edit', array('dados' => $dados));
    }

    public function editaTarefa(Request $req)
    {

        $data = $req->all();
        $id = $data['id_tarefa'];

        Tarefa::where('id', $id)
            ->update([
                'tarefa' => $data['tarefa'],
                'descricao' => $data['descricao'],
            ]);

        return redirect()->route('administrador.tarefas');
    }

    public function dadosTarefa($id)
    { //Ajax
        $dados = Tarefa::find($id);

        return compact('dados');
    }

    public function excluiTarefa($id, $s)
    {

        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            Tarefa::find($id)->delete();

            return 'true';
        } else {
            return 'password-problem';
        }

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

        return view('admin.usuario.editarFuncao')
            ->withUsuario($usuario)
            ->withFuncoes($funcoes)
            ->withTarefas($tarefas);
    }

    public function editaFuncaoUsuario(Request $req, $id)
    { // TODO: refatorar
        $data = $req->all();
        $funcoes = DB::table('funcao_pessoa')
            ->select('funcao_id')
            ->where('pessoa_id', $id)
            ->where(function ($q) {
                $q->where('edicao_id', Edicao::getEdicaoId());
                $q->orWhere('edicao_id', '=', 1);
            })
            ->get()
            ->keyBy('funcao_id')
            ->toArray();

        $usuario = Pessoa::find($id);

        if (isset($data['tarefa'])) {

            if ($usuario->tarefas->first() != null) {
                if ($usuario->tarefas->first()->id != $data['tarefa']) {
                    DB::table('pessoa_tarefa')
                        ->where('pessoa_id', $id)
                        ->where(function ($q) {
                            $q->where('edicao_id', Edicao::getEdicaoId());
                            $q->orWhere('edicao_id', '=', 1);
                        })
                        ->update(['tarefa_id' => $data['tarefa']]);
                }
            } else {
                DB::table('pessoa_tarefa')
                    ->insert([
                        'edicao_id' => Edicao::getEdicaoId(),
                        'tarefa_id' => $data['tarefa'],
                        'pessoa_id' => $id,
                    ]);
            }

        }

        if (!empty($funcoes)) {
            $funcaoId = array_keys($funcoes);
            foreach ($funcoes as $funcao) {
                if ($funcao->funcao_id == EnumFuncaoPessoa::getValue('Voluntario')) {
                    if (!isset($data['funcao']) || (!in_array($funcao->funcao_id, $data['funcao']))) {
                        DB::table('pessoa_tarefa')
                            ->where('edicao_id', Edicao::getEdicaoId())
                            ->where('pessoa_id', $id)
                            ->delete();
                    }
                }
                if ($funcao->funcao_id != EnumFuncaoPessoa::getValue('Autor') && $funcao->funcao_id != EnumFuncaoPessoa::getValue('Orientador') && $funcao->funcao_id != EnumFuncaoPessoa::getValue('Coorientador') && $funcao->funcao_id != EnumFuncaoPessoa::getValue('Avaliador') && $funcao->funcao_id != EnumFuncaoPessoa::getValue('Homologador')) {
                    if (!isset($data['funcao']) || (!in_array($funcao->funcao_id, $data['funcao']))) {
                        DB::table('funcao_pessoa')
                            ->where('funcao_id', $funcao->funcao_id)
                            ->where('pessoa_id', $id)
                            ->delete();
                    }
                }
            }

            if (isset($data['funcao'])) {
                foreach ($data['funcao'] as $funcao) {
                    if (!in_array($funcao, $funcaoId)) {
                        if ($funcao == EnumFuncaoPessoa::getValue('Voluntario') && Pessoa::find($id)->temTrabalho()) {
                        } else {
                            if ($funcao == EnumFuncaoPessoa::getValue('Administrador')) {
                                DB::table('funcao_pessoa')->insert([
                                    'funcao_id' => $funcao,
                                    'pessoa_id' => $id,
                                    'edicao_id' => 1,
                                    'homologado' => true,
                                ]);
                            } else {
                                DB::table('funcao_pessoa')->insert([
                                    'funcao_id' => $funcao,
                                    'pessoa_id' => $id,
                                    'edicao_id' => Edicao::getEdicaoId(),
                                    'homologado' => true,
                                ]);
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($data['funcao'] as $funcao) {
                if ($funcao == EnumFuncaoPessoa::getValue('Voluntario') && Pessoa::find($id)->temTrabalho()) {
                } else {
                    if ($funcao == EnumFuncaoPessoa::getValue('Administrador')) {
                        DB::table('funcao_pessoa')->insert([
                            'funcao_id' => $funcao,
                            'pessoa_id' => $id,
                            'edicao_id' => 1,
                            'homologado' => true,
                        ]);
                    } else {
                        DB::table('funcao_pessoa')->insert([
                            'funcao_id' => $funcao,
                            'pessoa_id' => $id,
                            'edicao_id' => Edicao::getEdicaoId(),
                            'homologado' => true,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('administrador.usuarios');
    }

    public function ocultarUsuario($id)
    {
        DB::table('pessoa')
            ->where('id', $id)
            ->update(['oculto' => true, 'newsletter' => false]);

        return redirect()->route('administrador.usuarios');
    }
    public function configuracoes(){
        return view('admin.configuracoes.configuracoes');
    }
   
    public function navbar(Request $request){
        $cor = Mensagem::where('nome','=','cor_navbar')->get();
        $cor[0]->conteudo = $request->cor;
        $cor[0]->timestamps = false;
        $cor[0]->save();
        return redirect()->route('admin.configuracoes');
    }
    public function empresas(){
        $empresas = Empresa::orderBy('nome_curto')->get();

        return view('admin.empresas.home', ['empresas' => $empresas]);
    }
    public function cadastroEmpresa(Request $req){
        $data = $req->all();
        $idEndereco = Endereco::create([
            'cep' => $data['cep'],
            'endereco' => $data['endereco'],
            'bairro' => $data['bairro'],
            'municipio' => $data['municipio'],
            'uf' => $data['uf'],
            'numero' => $data['numero'],
        ]);

        Empresa::create([
            'nome_completo' => $data['nome_completo'],
            'nome_curto' => $data['nome_curto'],
            'email' => $data['email'],
            'telefone' => $data['telefone'],
            'endereco_id' => $idEndereco['original']['id'],
        ]);

        return redirect()->route('admin.empresas');
      
    }
    public function NovaEmpresa(){
        return view('admin.empresas.create');
    }

    public function dadosEmpresa(Request $request, $id)
    {
        if ($request->ajax()) {
            $dados = Empresa::find($id);
            $data = Endereco::find($dados->endereco_id);
    
            return response()->json(['dados' => $dados, 'data' => $data]);
        }
    
        return abort(404);
    }
    public function editarempresa($id)
    {

        $data = '';
        $dados = Empresa::find($id);

        if ($dados['endereco_id']) {
            $data = Endereco::find($dados['endereco_id']);
        }

        return view('admin.empresas.edit', compact('dados', 'data'));

    }
    public function editaEmpresa(Request $req)
    {

        $data = $req->all();

        $id_empresa = $data['id_empresa'];
        $id_endereco = $data['id_endereco'];

        if ($id_endereco != 0) {

            Endereco::where('id', $id_endereco)
                ->update(['cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero'],
                ]);

        } else {

            $id_endereco = Endereco::create(['cep' => $data['cep'],
                'endereco' => $data['endereco'],
                'bairro' => $data['bairro'],
                'municipio' => $data['municipio'],
                'uf' => $data['uf'],
                'numero' => $data['numero'],
            ]);

            $id_endereco = $id_endereco['id'];

        }

        Empresa::where('id', $id_empresa)
            ->update(['nome_completo' => $data['nome_completo'],
                'nome_curto' => $data['nome_curto'],
                'email' => $data['email'],
                'telefone' => $data['telefone'],
                'endereco_id' => $id_endereco,
            ]);

        return redirect()->route('admin.empresas');
    }
    public function cordosavisos(Request $req){
        $cor = Mensagem::where('nome','=','cor_avisos')->get();
        $cor[0]->conteudo = $req->cor;
        $cor[0]->timestamps = false;
        $cor[0]->save();
        return redirect()->route('admin.configuracoes');

    }
    public function corBotoes(Request $req){
        $cor = Mensagem::where('nome', '=', 'cor_botoes')->get();
        $cor[0]->conteudo = $req->cor;
        $cor[0]->timestamps = false;
        $cor[0]->save();
    
        return redirect()->route('admin.configuracoes');
    }
    public function brindes(){
        $brindes = Brindes::orderBy('nome')->get();
        return view('admin.premiacao.home',['brindes' => $brindes]);
    }
    public function NovoBrinde(){
        return view('admin.premiacao.create');
    }
    public function cadastroBrinde(Request $req) {
        $data = $req->all();
        $brinde = Brindes::create([
            'nome' => $data['nome'],
            'quantidade' => $data['quantidade'],
            'descricao' => $data['descricao'],
            'tamanho' => $data['tamanho'],
        ]);
    
        DB::table('movimentacao_registros')->insert([
            'origem_destino' => $data['origem_destino'], // Update this based on your requirement
            'quantidade_movimentada' => $data['quantidade'],
            'data_movimentacao' => \Carbon\Carbon::now(),
            'brinde_id' => $brinde->id,
            'tipo_movimentacao' => true, // Assuming true represents "Adição"
        ]);
    
        return redirect()->route('admin.brindes');
    }
    
    public function dadosBrinde($id){
    $brinde = Brindes::find($id);

    return response()->json(['dados' => $brinde]);
    }
    public function editarbrindes($id){
        $brinde = Brindes::find($id);
        return view('admin.premiacao.edit', compact('brinde'));
    }
    public function editaBrinde(Request $request){
        $idBrinde = $request->input('id_brinde');
        $brinde = Brindes::find($idBrinde);
        
        // Faça as alterações necessárias no brinde com base nos dados enviados pelo formulário
        $brinde->descricao = $request->input('descricao');
        $brinde->tamanho = $request->input('tamanho');
        $brinde->save();
        
        return redirect()->route('admin.brindes')->with('success', 'Premiação atualizado com sucesso!');
    }
      public function adicionarQuantidade(Request $request)
    {
        // Valide os dados recebidos na requisição
        $this->validate($request, [
            'brinde_id' => 'required|integer',
            'quantidade' => 'required|integer|min:1',
            'origem_destino' => 'required|',
        ]);
        DB::table('movimentacao_registros')->insert([
            'origem_destino' => $request->origem_destino, // Update this based on your requirement
            'quantidade_movimentada' => $request->quantidade,
            'data_movimentacao' => \Carbon\Carbon::now(),
            'brinde_id' => $request->brinde_id,
            'tipo_movimentacao' => true, // Assuming true represents "Adição"
        ]);
        // Encontre o brinde pelo ID
        $brinde = Brindes::findOrFail($request->brinde_id);

        // Incremente a quantidade do brinde
        $brinde->quantidade += $request->quantidade;

        // Salve as mudanças no banco de dados
        $brinde->save();

        // Redirecione de volta à página anterior com uma mensagem de sucesso
        return back()->with('success', 'Quantidade adicionada com sucesso!');
    }
    public function decrementarQuantidade(Request $request)
    {
        // Valide os dados recebidos na requisição
        $this->validate($request, [
            'brinde_id' => 'required|integer',
            'quantidade' => 'required|integer|min:1',
        ]);
        DB::table('movimentacao_registros')->insert([
            'origem_destino' => $request->origem_destino, // Update this based on your requirement
            'quantidade_movimentada' => $request->quantidade,
            'data_movimentacao' => \Carbon\Carbon::now(),
            'brinde_id' => $request->brinde_id,
            'tipo_movimentacao' => false, // Assuming true represents "Adição"
        ]);

        // Encontre o brinde pelo ID
        $brinde = Brindes::findOrFail($request->brinde_id);

        // Verifique se a quantidade a decrementar é maior que a quantidade atual
        if ($request->quantidade > $brinde->quantidade) {
            return back()->with('error', 'A quantidade a decrementar é maior que a quantidade disponível!');
        }

        // Decremente a quantidade do brinde
        $brinde->quantidade -= $request->quantidade;

        // Salve as mudanças no banco de dados
        $brinde->save();

        // Redirecione de volta à página anterior com uma mensagem de sucesso
        return back()->with('success', 'Quantidade decrementada com sucesso!');
    }
    public function ocultarPessoa()
    {
        $pessoa = Auth::user();

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada.'], 404);
        }

        $pessoa->update(['oculto' => true]);

        return view('auth.oculto');
    }
    public function ocultar($id, Request $request){
        $novoEstado = $request->input('estado');
        $pessoa = Pessoa::where('id',$id)->first();

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada.'], 404);
        }

        $pessoa->oculto = $novoEstado;
        $pessoa->save();

        return response()->json(['message' => 'Pessoa Atualizada com sucesso.']);

    }

    public function fontes(Request $req){
        $fonte = Mensagem::where('nome', '=', 'fontes')->get();
        $fonte[0]->conteudo = $req->fonte;
        $fonte[0]->timestamps = false;
        $fonte[0]->save();
    
        return redirect()->route('admin.configuracoes');
    }
    public function showRegistros($id)
{
    // Fetch the data of the movement record with the provided ID
    $movimentoRegistro = DB::table('movimentacao_registros')->where('brinde_id', $id)->get();
    // You can return the data in a format that suits your needs, such as JSON or a view
    return response()->json($movimentoRegistro); // Or return a view with the data
}
    public  function getTotalRevisoes($id)
{
    $total = DB::table('revisao')
        ->select(DB::raw('count(*) as total'))
        ->join('public.pessoa', 'revisao.pessoa_id', '=', 'public.pessoa.id')
        ->join('projeto','revisao.projeto_id','projeto.id')
        ->where('projeto.edicao_id',Edicao::getEdicaoId())
        ->where('public.pessoa.id', '=', $id)
        ->first();

    return $total->total;
}
    public function Cursos(){
        $cursos = DB::table('cursos')->get();
        $nivel = DB::table('nivel')->get();
        return view('admin.cursos.home', compact('cursos','nivel'));
    }
    public function CreateCurso(Request $req){
       
        DB::table('cursos')->insert([
            'nome' => $req->input('nome'),
            'nivel_id'=> $req->input('nivel')
        ]);
      return redirect()->route('admin.cursos');
    }
    public function DeleteCurso(Request $req){
        DB::table('cursos')->where('id', $req->input('id'))->delete();
        return redirect()->route('admin.cursos');
    }
    public function UpdateCurso(Request $req){
        $curso = DB::table('cursos')->where('id', $req->input('id'))->first();
        $curso->nome = $req->input('nome');
        $curso->nivel_id = $req->input('nivel');
        $curso->timestamp = false;
        $curso->save();
        return redirect()->route('admin.cursos');
    }
    public function ReadCurso($id){
        $curso = DB::table('cursos')->where('id',$id)->first();
        if ($curso) {
            return response()->json($curso);
        } else {
            return response()->json(['error' => 'Curso não encontrado'], 404);
        }
    }
    public function GetTotalAvaliacoes($id){
        $total = DB::table('avaliacao')
        ->select(DB::raw('count(*) as total'))
        ->join('public.pessoa', 'avaliacao.pessoa_id', '=', 'public.pessoa.id')
        ->join('projeto','avaliacao.projeto_id','projeto.id')
        ->where('projeto.edicao_id',Edicao::getEdicaoId())
        ->where('public.pessoa.id', '=', $id)
        ->first();

    return $total->total;
    }
 
    public function excluir_voluntario(Request $req)
    {
        // Verifique se o usuário atual está autenticado como administrador

            $senhaAdmin = $req->input('senha');
            $idVoluntario = $req->input('id');

            // Verifique a senha do administrador
            if (password_verify($senhaAdmin, Auth::user()['attributes']['senha'])) {
                // Excluir relacionamentos de funções de pessoa (caso existam)
                DB::table('funcao_pessoa')
                    ->where('pessoa_id', $idVoluntario)
                    ->where('funcao_id', 9)
                    ->where('edicao_id', Edicao::getEdicaoId())
                    ->delete();

                // Excluir o voluntário
                DB::table('voluntarios')
                    ->where('id', $idVoluntario)
                    ->where('edicao_id', Edicao::getEdicaoId())
                    ->delete();

                return response()->json(['message' => 'Voluntário excluído com sucesso' ]);
            } else {
                return response()->json(['message' => 'Senha incorreta'], 401);
            }
        }
    public function funcoesAtivas($id){
        $funcoesAtivas = DB::table('pessoa_tarefa')
        ->where('edicao_id', Edicao::getEdicaoId())
        ->where('pessoa_id',$id)
        ->first();
        return response()->json($funcoesAtivas);
    }
    public function AtualizarFuncao(Request $request){
        $pessoa_id = $request->input('pessoa_id');
        $tarefa_id = $request->input('funcao'); 
        $funcoesAtivas = DB::table('pessoa_tarefa')
        ->where('edicao_id', Edicao::getEdicaoId())
        ->where('pessoa_id',$pessoa_id)
        ->first();
        if( $funcoesAtivas ==  null){
            DB::table('pessoa_tarefa')->insert([
                'pessoa_id' => $pessoa_id,
                'tarefa_id' => $tarefa_id,
                'edicao_id' => Edicao::getEdicaoId(),
            ]);
        }
        else{
            DB::table('pessoa_tarefa')
            ->where('pessoa_id', $pessoa_id)
            ->where('edicao_id', Edicao::getEdicaoId())
            ->update([
                'pessoa_id' => $pessoa_id,
                'tarefa_id' => $tarefa_id,
                'edicao_id' => Edicao::getEdicaoId(),
            ]);
        
            
        }
        return redirect()->route('administrador.comissao');

    }
}
