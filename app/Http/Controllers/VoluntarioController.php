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
    public function cadastrarVoluntario($s){
      if(password_verify($s, Auth::user()['attributes']['senha'])){
      	$id = DB::table('funcao')->where('funcao', 'Voluntário')->get();
      	foreach($id as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => Edicao::getEdicaoId(),
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => TRUE
                ]
        );
      }
          $emailJob = (new MailVoluntarioJob())->delay(\Carbon\Carbon::now()->addSeconds(3));
          dispatch($emailJob);
         
          return 'true';
      }

      return 'false';
    }
}
