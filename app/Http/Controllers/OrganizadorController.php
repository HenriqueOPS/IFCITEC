<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Edicao;
use App\Funcao;
use App\Projeto;
use App\Pessoa;
use App\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrganizadorController extends Controller
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

         $escolas = DB::table('escola')
        	->select('escola.id', 'nome_completo', 'nome_curto', 'email', 'telefone')
        	->orderBy('nome_curto', 'asc')
			 ->get();

        return view('organizacao.home')->withEscolas($escolas);
    }

	public function usuarios(){
		$usuarios = Pessoa::orderBy('nome')->get();

		return view('organizacao.usuarios')->withUsuarios($usuarios);
	}

    public function projetos() {

		$projetos = Projeto::select('titulo', 'id', 'situacao_id')
			->orderBy('titulo')
			->where('edicao_id', Edicao::getEdicaoId())
			->get()
			->keyBy('id');

		return view('organizacao.projetos')->withProjetos($projetos);

    }

    public function presenca() {
        return view('organizacao.presenca');
    }

}
