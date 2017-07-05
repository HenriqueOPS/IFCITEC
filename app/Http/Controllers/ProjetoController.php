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
use App\PalavraChave;

class ProjetoController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
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
        $funcoes = Funcao::all();
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
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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

}
