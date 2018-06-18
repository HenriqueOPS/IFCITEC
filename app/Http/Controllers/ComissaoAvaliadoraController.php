<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PeriodosController;
use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


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

    public function cadastraComissao(PeriodosController $p, Request $req){
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
                ['edicao_id' => $p->periodoComissao(),
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
                ['edicao_id' => $p->periodoComissao(),
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]);
        }
      }

        Mail::send('mail.primeiro', [], function($message){
            $message->to(Auth::user()->email);
            $message->subject('IFCITEC');
        });
        return redirect()->route('autor');

    }
}
