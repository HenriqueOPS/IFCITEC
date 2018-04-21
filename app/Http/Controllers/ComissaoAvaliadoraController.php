<?php

namespace App\Http\Controllers;
use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ComissaoAvaliadoraController extends Controller
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
    
    }
    public function cadastrarComissao($s, Request $req){
      if(password_verify($s, Auth::user()['attributes']['senha'])){
        dd($funcao);
        $data = $req->all();
        $idEndereco = Endereco::create([
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
        ]);

        DB::table('pessoa')->insert(
                ['titulacao' => $data['titulacao'], 
                    'lattes' => $data['lattes'], 
                    'profissao' => $data['profissao'],
                    'instituicao' => $data['instituicao'],
                    'endereco_id' => $idEndereco['original']['id'],
                ]
        )->where('id',Auth::$id);

        $id = DB::table('funcao')->where('funcao', 'Avaliador')->get(); //se marcou avaliador
        foreach($id as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 36, //pegar edição corrente
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]
        );

        $id = DB::table('funcao')->where('funcao', 'Homologador')->get(); //se marcou revisor
        foreach($id as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 36, //pegar edição corrente
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]
        );
          return 'true';
      }

      return 'false';
    }
}
