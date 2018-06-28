<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PeriodosController;
use App\Endereco;
use App\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailComissaoAvaliadoraJob;

class ComissaoAvaliadoraController extends Controller
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
        return view('avaliador.home');
    }

    public function cadastrarComissao(PeriodosController $p){
        $areas = DB::table('area_conhecimento')->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
                                    ->select('area_conhecimento.id','area_conhecimento.area_conhecimento', 'area_conhecimento.nivel_id')
                                    ->where('area_edicao.edicao_id', $p->periodoComissao())
                                    ->orderBy('area_conhecimento.id', 'asc')
                                    ->get()
                                    ->toArray();

        $niveis = DB::table('nivel')->join('nivel_edicao', 'nivel.id', '=', 'nivel_edicao.id')
                                    ->select('nivel.nivel', 'nivel.id','nivel_edicao.edicao_id')
                                    ->where('nivel_edicao.edicao_id', $p->periodoComissao())
                                    ->orderBy('nivel.id', 'asc')
                                    ->get()
                                    ->toArray();

        $orientador = DB::table('funcao')->select('id')
                                        ->where('funcao','Orientador')
                                        ->get();
        $coorientador = DB::table('funcao')->select('id')
                                        ->where('funcao','Coorientador')
                                        ->get();
    

        $projetosNiveis = DB::table('nivel')->join('projeto', 'nivel.id', '=', 'projeto.nivel_id')
                                    ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
                                    ->select('nivel.nivel', 'nivel.id')
                                    ->where('escola_funcao_pessoa_projeto.edicao_id', $p->periodoComissao())
                                    ->where('pessoa_id', Auth::user()->id)
                                    ->where('escola_funcao_pessoa_projeto.funcao_id', $orientador->get(0)->id)
                                    ->orWhere('escola_funcao_pessoa_projeto.funcao_id', $coorientador->get(0)->id)
                                    ->orderBy('nivel.id', 'asc')
                                    ->get()
                                    ->toArray();
        foreach ($niveis as $n) {
            foreach ($projetosNiveis as $pn) {      
                if($n->id != $pn->id){
                    $nivel = $n;
                }
            }
        }

        if ($projetosNiveis == null) {
            $nivel = $niveis;
        }

        return view('cadastroAvaliador', ['areas' => $areas,'nivel' => $nivel]);
    }

    public function cadastraComissao(PeriodosController $p, Request $req){
        $data = $req->all(); 
        $idEndereco = Endereco::create([
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
        ]);
        $id = DB::table('pessoa')->where('id',Auth::id())->update([
                    'titulacao' => $data['titulacao'], 
                    'lattes' => $data['lattes'], 
                    'profissao' => $data['profissao'],
                    'instituicao' => $data['instituicao'],
                    'endereco_id' => $idEndereco['original']['id'],
                ]
        );

        Pessoa::find($id)->edicoes()->attach(['edicao_id' => $p->periodoComissao()],
            ['pessoa_id' => Auth::id()]);


        $comissaoEdicao = DB::table('comissao_edicao')->select('id')
                                    ->where('edicao_id', $p->periodoComissao())
                                    ->where('pessoa_id', Auth::id())
                                    ->get();
        $areas = $data['area_id'];
        foreach ($areas as $area) {
            DB::table('areas_comissao')->insert(
                ['area_id' => $area,
                    'comissao_edicao_id' => $comissaoEdicao->get(0)->id, 
                    'homologado' => FALSE
                ]);
        }

        if(in_array("1", $data['funcao'])){
        $idA = DB::table('funcao')->where('funcao', 'Avaliador')->get(); 
        foreach($idA as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoComissao(),
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]);
        }
        }

        if(in_array("2", $data['funcao'])){
        $idH = DB::table('funcao')->where('funcao', 'Homologador')->get(); 
        foreach($idH as $i){
          DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoComissao(),
                    'funcao_id' => $i->id, 
                    'pessoa_id' => Auth::id(),
                    'homologado' => FALSE
                ]);
        }
      }

        $emailJob = (new MailComissaoAvaliadoraJob())->delay(\Carbon\Carbon::now()->addSeconds(3));
        dispatch($emailJob);
        return redirect()->route('autor');

    }
}

