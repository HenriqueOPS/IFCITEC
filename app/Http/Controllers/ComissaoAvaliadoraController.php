<?php

namespace App\Http\Controllers;
use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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

    public function cadastraComissao(Request $req){
        $data = $req->all(); 
        $idEndereco = Endereco::create([
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
        ]);
        DB::table('pessoa')->where('id',Auth::id())->update([
                    'titulacao' => $data['titulacao'], 
                    'lattes' => $data['lattes'], 
                    'profissao' => $data['profissao'],
                    'instituicao' => $data['instituicao'],
                    'endereco_id' => $idEndereco['original']['id'],
                ]
        );

        if(in_array("1", $data['funcao'])){
        $idA = DB::table('funcao')->where('funcao', 'Avaliador')->get(); 
        foreach($idA as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 36, //pegar edição corrente
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]);
        }
        }

        if(in_array("2", $data['funcao'])){
        $idH = DB::table('funcao')->where('funcao', 'Homologador')->get(); 
        foreach($idH as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 36, //pegar edição corrente
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]);
        }
      }
        
        return redirect()->route('autor');

    }
}
