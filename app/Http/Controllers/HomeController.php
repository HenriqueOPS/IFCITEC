<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mensagem;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $instagram1 = Mensagem::where('nome', '=', 'PrimeiraColuna' )->get();
        $instagram2 = Mensagem::where('nome', '=', 'SegundaColuna' )->get();
        $instagram3 = Mensagem::where('nome', '=', 'TerceiraColuna' )->get();
        return view('home',[
            'instagram1'=>$instagram1[0]->conteudo,
            'instagram2'=>$instagram2[0]->conteudo,
            'instagram3'=>$instagram3[0]->conteudo,
        ]);
    }
}
