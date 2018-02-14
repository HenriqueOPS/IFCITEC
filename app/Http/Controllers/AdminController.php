<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use App\Edicao;

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
        $escolas = DB::table('escola')->select('id', 'nome_curto', 'email', 'telefone')
                                      ->orderBy('nome_curto', 'asc')
                                      ->get();

        //dd($edicoes);

        return view('admin.home', collect(['edicoes' => $edicoes, 'escolas' => $escolas]));

    }

    public function editarEscola($id){

        return "Escola ID: ".$id;

    }

    public function cadastroEscola()
    {
        return view('admin.cadastroEscola');
    }
    public function cadastraEscola(Request $req)
    {

        $req = $req->all();

        dd($req);



    }

    public function cadastroArea()
    {
        return view('admin.cadastroArea');
    }

    public function cadastroNivel()
    {
        return view('admin.cadastroNivel');
    }

    public function administrarUsuarios()
    {
        return view('admin.administrarUsuarios');
    }
}
