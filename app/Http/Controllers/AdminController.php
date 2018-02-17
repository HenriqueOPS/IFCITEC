<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use App\Edicao;
use App\Escola;
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
        $escolas = DB::table('escola')->select('id', 'nome_curto', 'email', 'telefone', 'municipio')
                                      ->orderBy('nome_curto', 'asc')
                                      ->get();

        return view('admin.home', collect(['edicoes' => $edicoes, 'escolas' => $escolas]));

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
      return $dados;
    }

    public function editarEscola($id) {
        $dados = Escola::find($id);

        return view('admin.editarEscola', compact('dados'));
    }

    public function editaEscola(Request $req) {
        $data = $req->all();
        
        Escola::find($data['id_escola'])->update($data);

        return redirect()->route('administrador');
    }

    public function cadastroEscola() {
        return view('admin.cadastroEscola');
    }

    public function cadastraEscola(Request $req){
        $data = $req->all();

        Escola::create([
                    'nome_completo' => $data['nome_completo'],
                    'nome_curto' => $data['nome_curto'],
                    'email' => $data['email'],
                    'telefone' => $data['telefone'],
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
                  ]);

        return redirect()->route('administrador');
    }


    

    public function administrarUsuarios()
    {
        return view('admin.administrarUsuarios');
    }
}
