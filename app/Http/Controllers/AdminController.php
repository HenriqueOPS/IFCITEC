<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdministrador');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    public function edicao($id)
    {
        return view('admin.homeEdicao');
    }

    public function cadastroEscola()
    {
        return view('admin.cadastroEscola');
    }

    public function cadastroArea()
    {
        return view('admin.cadastroArea');
    }

    public function cadastroNivel()
    {
        return view('admin.cadastroNivel');
    }

    public function cadastroEdicao()
    {
        return view('admin.cadastroEdicao');
    }
    
    public function editarArea()
    {
        return view('admin.editarArea');
    }
    
    public function editarEdicao()
    {
        return view('admin.editarEdicao');
    }
    
    public function editarEscola()
    {
        return view('admin.editarEscola');
    }
    
    public function editarNivel()
    {
        return view('admin.editarNivel');
    }
    
    public function mostrarEdicao()
    {
        return view('admin.showEdicao');
    }
    
    public function administrarUsuarios()
    {
        return view('admin.administrarUsuarios');
    }
}
