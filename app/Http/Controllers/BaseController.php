<?php

namespace App\Http\Controllers;
use App\Mensagem;
use Illuminate\Http\Request;

class BaseController extends Controller
{
  
    public function __construct()
    {
    $cor = Mensagem::where('nome', '=', 'cor_navbar' )->get();
    view()->share('cor', $cor[0]->conteudo);
    }
  
}
