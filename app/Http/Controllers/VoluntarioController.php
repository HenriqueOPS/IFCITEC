<?php
namespace App\Http\Controllers;

use App\Http\Controllers\PeriodosController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailVoluntarioJob;

use App\Edicao;
use App\Pessoa;
use App\Funcao;
use App\Tarefa;

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
    public function index(){
        if(Pessoa::find(Auth::id())->temFuncao('Voluntário') == true) {
        	if (Pessoa::find(Auth::id())->temTarefa()) {
        		 $tarefa = DB::table('pessoa_tarefa')
		            ->select('tarefa.tarefa')
		            ->join('tarefa','pessoa_tarefa.tarefa_id','=','tarefa.id')
		            ->where('pessoa_tarefa.pessoa_id','=',Auth::id())
		            ->get();
        		return view('tarefa',array('tarefa' => $tarefa));
        	}
        	else{
          		return view('inscricaoEnviada');
      		}
        }else{
            $tarefas = Tarefa::orderBy('tarefa')->get();

            return view('voluntario')->withTarefas($tarefas);
        }
    }

    public function cadastraVoluntario(Request $req){
        $data = $req->all();
		if(! Auth::user()->temTrabalho()) {

			DB::table('funcao_pessoa')->insert(
				['edicao_id' => Edicao::getEdicaoId(),
					'funcao_id' => Funcao::where('funcao', 'Voluntário')->first()->id,
					'pessoa_id' => Auth::id(),
					'homologado' => false
				]
			);

			$emailJob = (new MailVoluntarioJob())->delay(\Carbon\Carbon::now()->addSeconds(3));
			dispatch($emailJob);


			return view('inscricaoEnviada');
		}
		else{
			return view('temTrabalho');
		}
    }
}
