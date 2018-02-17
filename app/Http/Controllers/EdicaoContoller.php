<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjetoRequest;
use Illuminate\Support\Facades\Response;

use App\Edicao;


class EdicaoController extends Controller {

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



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cadastraEdicao(Request $req) {

        //Busca o ano da ultima edição cadastrada no banco
        $query = DB::table('edicao')->select('edicao.ano')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
        //Incrementa o ano
        $ano = ++$query[0]->ano;

        $data = $req->all();
        $data['ano'] = $ano;

        //dd($data);

        Edicao::create($data);

        return redirect()->route('administrador');
        
    }

    public function editarEdicao($id) {

        $dados = Edicao::find($id);

        return view('admin.editarEdicao',compact('dados'));
        
    }


    //Retorna os dados de uma determinada edição
    public function edicao($id)
    {

        $query = DB::table('edicao')->select('edicao.ano')
            ->where('id','=',$id)
            ->get();
        $ano = $query[0]->ano;

        $niveis = DB::table('nivel')->select('nivel.*')
            ->where('edicao_id','=',$id)
            ->get();


        return view('admin.homeEdicao', collect([
                                                'ano' => $ano, 
                                                'id' => $id, 
                                                'projetos' => '', 
                                                'areas' => '', 
                                                'niveis' => $niveis
                                                ]));
    }

    public function cadastroEdicao()
    {
        return view('admin.cadastroEdicao');
    }

}


