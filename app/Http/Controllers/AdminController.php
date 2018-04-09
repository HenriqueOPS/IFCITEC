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
        $niveis = DB::table('nivel')->select('nivel.*')
                                    ->orderBy('nivel', 'asc')
                                    ->get();
        $areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id',                            '=', 'nivel.id')
                                      ->select('area_conhecimento.id', 'area_conhecimento', 'area_conhecimento.descricao')              
                                      ->orderBy('area_conhecimento', 'asc')
                                      ->get();
        $enderecos = DB::table('endereco')->select('endereco.id', 'endereco', 'numero', 'bairro', 'municipio', 'uf', 'cep')
                                      ->orderBy('id', 'asc')
                                      ->get();
        $escolas = DB::table('escola')
                                      ->select('escola.id', 'escola.nome_completo', 'escola.nome_curto', 'escola.email',
                                      'escola.telefone')
                                      ->get();


        return view('admin.home', collect(['edicoes' => $edicoes, 'enderecos' => $enderecos, 'escolas' => $escolas, 'niveis' => $niveis, 'areas' => $areas]));

    }


    public function dadosNivel($id) { //Ajax
      $dados = Nivel::find($id);
      return compact('dados');
    }

    public function cadastroNivel() {
        return view('admin.cadastroNivel');
    }


    public function cadastraNivel(Request $req){
        $data = $req->all();     
        Nivel::create([
                    'nivel' => $data['nivel'],
                    'descricao' => $data['descricao'],
                    'max_ch' => $data['max_ch'],
                    'min_ch' => $data['min_ch'],
                  ]);
                   
        return redirect()->route('administrador');
        
    }

    public function editarNivel($id) {
     
       
        $dados = Nivel::find($id);

        return view('admin.editarNivel', compact('dados'));
    }

    public function editaNivel(Request $req) {

        $id = $req->all()['id_nivel'];
        Nivel::where('id',$id)->update(['nivel'=>$req->all()['nivel'],
                                          'max_ch'=>$req->all()['max_ch'],
                                         'min_ch'=>$req->all()['min_ch'],
                                         'descricao'=>$req->all()['descricao'],
      ]);

        return redirect()->route('administrador');
    }

    public function excluiNivel($id, $s){
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


    public function dadosArea($id) { //Ajax
      $dados = AreaConhecimento::find($id);
      return $dados;
    }

    public function cadastroArea() {
        return view('admin.cadastroArea'); //,hasMany
    }

    public function cadastraArea(Request $req){
        $data = $req->all();

      

        Escola::create([
                    'nome_completo' => $data['nome_completo'],
                    'nome_curto' => $data['nome_curto'],
                    'email' => $data['email'],
                    'telefone' => $data['telefone'],
                    'endereco_id' => $idEndereco['original']['id']
                  ]);

        

        return redirect()->route('administrador');
        
    }

    public function editarArea($id) {
     
       
        $dados = AreaConhecimento::find($id);

        return view('admin.editarArea', compact('dados'));
    }

    public function editaArea(Request $req) {

        $id = $req->all()['id_area'];
        AreaConhecimento::where('id',$id)->update(['area_conhecimento'=>$req->all()[
                                          'area_conhecimento'],
                                          'descricao'=>$req->all()['descricao'],
      ]);

        return redirect()->route('administrador');
    }

    public function dadosEscola($id) { //Ajax
      $dados = Escola::find($id);
      $data = Endereco::find($dados->endereco_id);
      return compact('dados','data');
    }

    public function editarEscola($id) {
     
       
        $dados = Escola::find($id);
        $endereco = 0;

        if($dados->endereco_id != null){
            $data = Endereco::find($dados->endereco_id);
            $endereco = 1;
        }

        return view('admin.editarEscola', compact('dados','data', 'endereco'));
    }

    public function editaEscola(Request $req) {

        $id = $req->all()['id_escola'];

        $dados = Escola::find($id);

        if($dados->endereco_id != null){ //existe um endereço

            Endereco::where('id',$dados->endereco_id)->update(['cep'=>$req->all()['cep'],
                'endereco'=>$req->all()['endereco'],
                'bairro'=>$req->all()['bairro'],
                'municipio'=>$req->all()['municipio'],
                'uf'=>$req->all()['uf'],
                'numero'=>$req->all()['numero'],
            ]);

            Escola::where('id',$id)->update(['nome_completo'=>$req->all()['nome_completo'],
                'nome_curto'=>$req->all()['nome_curto'],
                'email'=>$req->all()['email'],
                'telefone'=>$req->all()['telefone'],
            ]);

        }else{ //nao existe um endereço

            $idEndereco = Endereco::create(['cep'=>$req->all()['cep'],
                'endereco'=>$req->all()['endereco'],
                'bairro'=>$req->all()['bairro'],
                'municipio'=>$req->all()['municipio'],
                'uf'=>$req->all()['uf'],
                'numero'=>$req->all()['numero'],
            ]);

            Escola::where('id',$id)->update(['nome_completo'=>$req->all()['nome_completo'],
                'nome_curto'=>$req->all()['nome_curto'],
                'email'=>$req->all()['email'],
                'telefone'=>$req->all()['telefone'],
                'endereco_id' => $idEndereco['original']['id']
            ]);

        }




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
