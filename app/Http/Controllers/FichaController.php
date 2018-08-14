<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichaController extends Controller
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

    public function cadastroFichaHomologacao()
    {
         $edicoes = DB::table('edicao')->select('id','ano')->get();
         
         return view('cadastroFichaHomologacao',['edicoes' => $edicoes]);
    }
}