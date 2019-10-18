<?php

namespace App\Http\Controllers;

use App\Edicao;
use App\Projeto;
use Illuminate\Support\Facades\Auth;

class AutorController extends Controller
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

		$projetos = [];

		$projetos['autor'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 5) // Autor
			->get();

		$projetos['orientador'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 7) // Orientador
			->get();

		$projetos['coorientador'] = Projeto::select('id', 'titulo')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'projeto_id')
			->where('pessoa_id', '=', Auth::user()->id)
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 6) // Coorientador
			->get();

		return view('user.home')->withProjetos($projetos);
    }

}
