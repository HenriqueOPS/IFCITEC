<?php
namespace App\Http\Controllers;
//use Vendor\Nesbot\Carbon\Src\Carbon\Carbon;
use App\Http\Controllers\PeriodosController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailVoluntarioJob;

use App\Edicao;
use App\Pessoa;
use App\Funcao;

class VoluntarioController extends Controller
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
        if (Pessoa::find(Auth::id())->temFuncao('Voluntário') == true) {
          return view('inscricaoEnviada');
        }
        else{
          return view('voluntario');
        }
    }
    public function cadastrarVoluntario($s){
      if(password_verify($s, Auth::user()['attributes']['senha'])){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => Edicao::getEdicaoId(),
                    'funcao_id' => Funcao::where('funcao', 'Voluntário')->first()->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => TRUE
                ]
        );

          $emailJob = (new MailVoluntarioJob())->delay(\Carbon\Carbon::now()->addSeconds(3));
          dispatch($emailJob);
         
          return 'true';
      }

      return 'false';
    }
}
