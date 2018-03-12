<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use App\Edicao;
use App\Escola;
use App\Endereco;
use App\Nivel;
use App\AreaConhecimento;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        //$this->middleware('isAdministrador');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $edicoes = DB::table('edicao')->select('edicao.*')->get();
        $enderecos = DB::table('endereco')->select('endereco.id', 'endereco', 'numero', 'bairro', 
                                      'municipio', 'uf', 'cep')
                                      ->orderBy('id', 'asc')
                                      ->get();
        $escolas = DB::table('escola')->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
                                      ->select('escola.id', 'nome_completo', 'nome_curto', 'email', 
                                      'telefone', 'municipio')              
                                      ->orderBy('nome_curto', 'asc')
                                      ->get();

        return view('admin.home', collect(['edicoes' => $edicoes, 'enderecos' => $enderecos, 'escolas' => $escolas]));

    }


    public function dadosNivel($id) { //Ajax
      $dados = Nivel::find($id);
      return $dados;
    }

    public function cadastroNivel() {
        return view('admin.cadastroNivel');
    }


    public function dadosArea($id) { //Ajax
      $dados = AreaConhecimento::find($id);
      return $dados;
    }

    public function cadastroArea() {
        return view('admin.cadastroArea');
    }

    
    public function dadosEscola($id) { //Ajax
      $dados = Escola::find($id);
      $data = Endereco::find($dados->endereco_id);
      return compact('dados','data');
    }

    public function editarEscola($id) {
     
       
        $dados = Escola::find($id);
        $data = Endereco::find($dados->endereco_id);

        return view('admin.editarEscola', compact('dados','data'));
    }

    public function editaEscola(Request $req) {

        $id = $req->all()['id_escola'];
        Escola::where('id',$id)->update(['nome_completo'=>$req->all()['nome_completo'],
                                         'nome_curto'=>$req->all()['nome_curto'],
                                         'email'=>$req->all()['email'],
                                         'telefone'=>$req->all()['telefone'],
                                         

      ]);
        $data = $req->all()['id_endereco'];
        Endereco::where('id',$data)->update(['cep'=>$req->all()['cep'],
                                         'endereco'=>$req->all()['endereco'],
                                         'bairro'=>$req->all()['bairro'],
                                         'municipio'=>$req->all()['municipio'],
                                         'uf'=>$req->all()['uf'],
                                         'numero'=>$req->all()['numero'],


      ]);

        return redirect()->route('administrador');
    }

    public function cadastroEscola() {
        return view('admin.cadastroEscola');
    }

    public function cadastraEscola(Request $req){
        $data = $req->all();

        $idEndereco = Endereco::create([
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
        ]);

        Escola::create([
                    'nome_completo' => $data['nome_completo'],
                    'nome_curto' => $data['nome_curto'],
                    'email' => $data['email'],
                    'telefone' => $data['telefone'],
                    'endereco_id' => $idEndereco['original']['id']
                  ]);

        

        return redirect()->route('administrador');
        
    }


    public function excluiEscola($id, $s){
     /* print_r(Auth::user()['attributes']['senha']);
      echo '<br>';
      print_r(bcrypt($s));
      dd($s);*/
      if(password_verify($s, Auth::user()['attributes']['senha'])){
          Escola::find($id)->delete();
          return 'true';
      }

      return 'false';
    }

    public function administrarUsuarios()
    {
        return view('admin.administrarUsuarios');
    }
}
