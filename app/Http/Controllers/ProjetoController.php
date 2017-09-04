<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjetoRequest;
//
use App\Nivel;
use App\AreaConhecimento;
use App\Funcao;
use App\Escola;
use App\Projeto;
use App\Pessoa;
use App\PalavraChave;
use App\Revisao;

class ProjetoController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('checkAuthorship', ['only' => 'show']);
        $this->middleware('isOrganizacao', ['only' => 'create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $niveis = Nivel::all();
        $funcoes = Funcao::getByCategory('integrante');
        $escolas = Escola::all();
        return view('projeto.create')->withNiveis($niveis)->withFuncoes($funcoes)->withEscolas($escolas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjetoRequest $request) {
        $projeto = new Projeto();
        $projeto->fill($request->toArray());
        $projeto->titulo = strtoupper($request->titulo);
        //
        $areaConhecimento = AreaConhecimento::find($request->area);
        $nivel = Nivel::find($request->nivel);
        $projeto->areaConhecimento()->associate($areaConhecimento);
        $projeto->nivel()->associate($nivel);
        //
        $projeto->save();
        //--Inicio Attachment de Palavras Chaves. Tabela: palavra_projeto
        $palavrasChaves = explode(",", $request->palavras_chaves);
        foreach ($palavrasChaves as $palavra) {
            $projeto->palavrasChaves()->attach(PalavraChave::create(['palavra' => $palavra]));
        }
        //--Inicio Attachment de Participante. Tabela: escola_funcao_pessoa_projeto
        //Insert via DB pois o Laravel não está preparado para um tabela de 4 relacionamentos
        DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $request->funcao,
                    'pessoa_id' => Auth::id(),
                    'projeto_id' => $projeto->id
                ]
        );
        //
        return redirect()->route('projeto.show', ['projeto' => $projeto->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $projeto = Projeto::find($id);
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        return view('projeto.show')->withProjeto($projeto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function showFormVinculaIntegrante($id) {
        $projeto = Projeto::find($id);
        //É necessário um refact neste bloco:
        //Bloqueando roles no projeto conforme regulamento
        $funcoes = Funcao::getByCategory('integrante');
        $totalFuncoes = $projeto->getTotalFuncoes($funcoes);
        if($totalFuncoes['Autor'] >= 3){
            unset($funcoes[0]);
        }
         if($totalFuncoes['Coorientador'] >= 2){
            unset($funcoes[1]);
        }
         if($totalFuncoes['Orientador'] >= 1){
            unset($funcoes[2]);
        }
        
        //Fim do refact necessário
        $escolas = Escola::all();
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        return view('projeto.vinculaIntegrante')->withProjeto($projeto)->withFuncoes($funcoes)->withEscolas($escolas);
    }

    public function vinculaIntegrante(Request $request) {
        //Insert via DB pois o Laravel não está preparado para um tabela de 4 relacionamentos
        DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $request->funcao,
                    'pessoa_id' => $request->pessoa,
                    'projeto_id' => $request->projeto
                ]
        );
        
        return redirect()->route('projeto.show', ['projeto' =>$request->projeto]);
    }

    public function showFormVinculaRevisor($id){
        $projeto = Projeto::find($id);
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        $revisores = (DB::table('revisoresview')->select('*')->orderBy('titulacao')->get());
       // $revisores = (Pessoa::whereFuncao('Revisor')->orderBy('titulacao')->get());

        return view('organizacao.vinculaRevisor')
            ->withRevisores($revisores)
            ->withProjeto($projeto);
    }

    public function vinculaRevisor(Request $request){
        $revisao = new Revisao();
        $revisao->projeto_id = $request->projeto_id;
        $revisao->pessoa_id =  $request->revisor_id;
        $revisao->situacao_id =  4;
        $revisao->save();

        return redirect('home');
    }

    public function searchPessoaByEmail($id, $email){

        $pessoa = Pessoa::findByEmail($email);
        if (!($pessoa instanceof Pessoa)) {
            return response()->json(['error' => "A pessoa não está inscrita no sistema!"], 200);
        }

        $projeto = Projeto::find($id);
        $integrantes = $projeto->pessoas;
        if($integrantes->contains($pessoa)){
            return response()->json(['error' => "Esta pessoa já está vinculada ao projeto"], 200);
        }
        return response()->json($pessoa, 200);
    }

}
