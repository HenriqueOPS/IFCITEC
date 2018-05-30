<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Funcao;

class AutorController extends Controller
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
        $funcoes = DB::table('funcao_pessoa')->select('funcao_id')->where('pessoa_id', '=', Auth::user()->id)->get();
        $projetoPessoa = DB::table('escola_funcao_pessoa_projeto')->select('projeto_id')->where('pessoa_id', '=', Auth::user()->id)->get();
        $projetos = DB::table('projeto')->select('id','resumo','titulo')->get();
        
        foreach($projetoPessoa as $p){
          $pPessoa[] = $p->projeto_id;
        }
        foreach($projetos as $p){
            if(in_array($p->id, $pPessoa)){
                $proj[] = $p;
            }
        }
        if(isset($proj) == false){
            $proj = null;
        }
        return view('user.home', array(
      'projetos' => $proj))->withFuncoes($funcoes);
    }
}