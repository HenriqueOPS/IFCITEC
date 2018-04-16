<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoluntarioController extends Controller
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
        return view('voluntario');
    }
    public function cadastrar($s,Request $req){
    $data = $req->all();
      if(password_verify($s, Auth::user()['attributes']['senha'])){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 36,
                    'funcao_id' => 9,
                    'pessoa_id' => Auth::id(),
                    'homologado' => TRUE
                ]
        );
          return 'true';
      }

      return 'false';
    }
}
