<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
        if(Auth::user()->lgpddata==null || Auth::user()->genero!=null ){
        $instagram1 = Mensagem::where('nome', '=', 'PrimeiraColuna' )->get();
        $instagram2 = Mensagem::where('nome', '=', 'SegundaColuna' )->get();
        $instagram3 = Mensagem::where('nome', '=', 'TerceiraColuna' )->get();
        $aviso = Mensagem::where('nome', '=', 'Aviso(InscricoesAbertas)' )->get();
        return view('home',[
            'instagram1'=>$instagram1[0]->conteudo,
            'instagram2'=>$instagram2[0]->conteudo,
            'instagram3'=>$instagram3[0]->conteudo,
            'aviso'=>$aviso[0]->conteudo,
        ]);
    }else if (Auth::user()->genero==null){
        return redirect()->route('editarCadastro');
    }
    }
}
