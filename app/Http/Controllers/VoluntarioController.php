<?php
namespace App\Http\Controllers;
use App\Http\Controllers\PeriodosController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        return view('voluntario');
    }
    public function cadastrarVoluntario(PeriodosController $p, $s){
      if(password_verify($s, Auth::user()['attributes']['senha'])){
      	$id = DB::table('funcao')->where('funcao', 'Voluntário')->get();
      	foreach($id as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoVoluntario(),
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => TRUE
                ]
        );
      }
          Mail::send('mail.mailVoluntario', [Auth::user()->nome], function($message){
            $message->to(Auth::user()->email);
            $message->subject('IFCITEC');
        });
          return 'true';
      }

      return 'false';
    }
}
