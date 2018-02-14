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
    public function create() {

    }

    /**
     * Busca pela edição atual
     *
     */

    public function edicao($id)
    {

        $query = DB::table('edicao')->select('edicao.ano')
            ->where('id','=',$id)
            ->get();
        $ano = $query[0]->ano;

        return view('admin.homeEdicao', collect(['ano' => $ano, 'id' => $id, 'projetos' => '', 'areas' => '', 'niveis' => '']));
    }

    public function cadastroEdicao()
    {
        return view('admin.cadastroEdicao');
    }

    //Retorna o id da edição caso exista uma edicao com o período de inscrição aberto
    public function periodoInscricao(){

        /*

        SELECT e.id FROM public.edicao AS e
        INNER JOIN public.periodo AS p ON e.periodo_inscricao = p.id
        WHERE p.data_abertura <= (now() AT TIME ZONE 'America/Sao_Paulo')
        AND p.data_fechamento >= (now() AT TIME ZONE 'America/Sao_Paulo')

        */


        $query = DB::table('edicao')->select('edicao.id')
            ->join('periodo', 'edicao.periodo_inscricao', '=', 'periodo.id')
            ->whereRaw('periodo.data_abertura <= (now() AT TIME ZONE \'America/Sao_Paulo\')')
            ->whereRaw('periodo.data_fechamento >= (now() AT TIME ZONE \'America/Sao_Paulo\')')
            ->limit(1);


        return $query->get();

    }

}


