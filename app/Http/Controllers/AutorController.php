<?php

namespace App\Http\Controllers;

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
        $funcoes = Funcao::getByCategory('integrante');
        return view('user.home')->withFuncoes($funcoes);
    }
}