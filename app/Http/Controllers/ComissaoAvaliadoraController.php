<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PeriodosController;
use App\Endereco;
use App\Funcao;
use App\Pessoa;
use App\Edicao;
use App\Projeto;
use function foo\func;
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

        if ((Edicao::consultaPeriodo('Homologação') &&
            Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Homologador'))) {

            $idOk = DB::table('revisao')
                ->select('revisao.projeto_id')
                ->where('pessoa_id', '=', Auth::user()->id)
                ->where('revisado','=',true)
                ->get()
                ->toArray();

            $idOk = array_column($idOk, 'projeto_id');

            $projetos = Projeto::select('projeto.id', 'projeto.titulo', 'projeto.situacao_id')
                ->join('revisao', function($query){
                    $query->on('projeto.id','=','revisao.projeto_id');
                    $query->where('revisao.pessoa_id','=',Auth::user()->id);
                })
                ->orderBy('revisao.revisado','asc')
                ->get();

            return view('comissao.home', compact('idOk'))->withProjetos($projetos);

        } elseif (Edicao::consultaPeriodo('Avaliação') &&
                  Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Avaliador')){

            $idOk = DB::table('avaliacao')
                ->select('avaliacao.projeto_id')
                ->where('pessoa_id', '=', Auth::user()->id)
                ->where('avaliado','=',true)
                ->get()
                ->toArray();

            $idOk = array_column($idOk, 'projeto_id');

            $projetos = Projeto::select('projeto.id', 'projeto.titulo', 'projeto.situacao_id')
                ->join('avaliacao', function($query){
                    $query->on('projeto.id','=','avaliacao.projeto_id');
                    $query->where('avaliacao.pessoa_id','=',Auth::user()->id);
                })
                ->orderBy('avaliacao.avaliado','asc')
                ->get();

            return view('comissao.home', compact('idOk'))->withProjetos($projetos);


        }elseif (Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Avaliador') ||
            Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Homologador')) {
            return view('inscricaoEnviada');
        } else{
            //@TODO: redirecionar de acordo com a função e o período
            return redirect()->route('comissaoAvaliadora');
        }
    }

    public function home(){
        return view('avaliador.home');
    }

    public function cadastrarComissao(){
        $areas = DB::table('area_conhecimento')->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
                                    ->select('area_conhecimento.id','area_conhecimento.area_conhecimento', 'area_conhecimento.nivel_id')
                                    ->where('area_edicao.edicao_id', Edicao::getEdicaoId())
                                    ->orderBy('area_conhecimento.id', 'asc')
                                    ->get()
                                    ->toArray();

        $niveis = DB::table('nivel')->join('nivel_edicao', 'nivel.id', '=', 'nivel_edicao.nivel_id')
                                    ->select('nivel.nivel', 'nivel.id','nivel_edicao.edicao_id')
                                    ->where('nivel_edicao.edicao_id', Edicao::getEdicaoId())
                                    ->orderBy('nivel.id', 'asc')
                                    ->get()
                                    ->toArray();

        $projetosAreas = DB::table('area_conhecimento')->join('projeto', 'area_conhecimento.id', '=', 'projeto.area_id')
                                    ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
                                    ->select('area_conhecimento.area_conhecimento', 'area_conhecimento.id')
                                    ->where('escola_funcao_pessoa_projeto.edicao_id', Edicao::getEdicaoId())
                                    ->where('pessoa_id', Auth::user()->id)
                                    ->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::select(['id'])->where('funcao', 'Orientador')->first()->id)
                                    ->orWhere('escola_funcao_pessoa_projeto.funcao_id', Funcao::select(['id'])->where('funcao', 'Coorientador')->first()->id)
                                    ->orderBy('area_conhecimento.id', 'asc')
                                    ->get()
                                    ->keyBy('id')
                                    ->toArray();

        $projetosAreas = array_keys($projetosAreas);

        foreach ($areas as $a) {
            if (!in_array($a->id, $projetosAreas)) {
                    if(! isset($areasConhecimento)){
                        $areasConhecimento[] = $a;
                    }
                   else{
                        $array = array_pluck($areasConhecimento, 'id');
                        if(! in_array($a->id, $array)){
                            $areasConhecimento[] = $a;
                        }
                    }
            }
        }

        if ($projetosAreas == null) {
            $areasConhecimento = $areas;
        }

        $dados = Pessoa::find(Auth::id());

        if($dados->titulacao != null){
            $data = Endereco::find($dados->endereco_id);
        }
        else{
            $data = null;
        }

        return view('comissao.cadastro', ['areas' => $areas,'niveis' => $niveis, 'dados' => $dados, 'data' => $data, 'areasConhecimento' => $areasConhecimento]);
    }

    public function cadastraComissao(Request $req){
        $data = $req->all();
        if(Pessoa::find(Auth::id())->endereco_id != null){
            $idEndereco = DB::table('endereco')->where('id',Pessoa::find(Auth::id())->endereco_id)->update([
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
                ]
            );
        }
        else{
        $idEndereco = Endereco::create([
                    'cep' => $data['cep'],
                    'endereco' => $data['endereco'],
                    'bairro' => $data['bairro'],
                    'municipio' => $data['municipio'],
                    'uf' => $data['uf'],
                    'numero' => $data['numero']
        ]);
        }
       $id = DB::table('pessoa')->where('id',Auth::id())->update([
                    'titulacao' => $data['titulacao'],
                    'lattes' => $data['lattes'],
                    'profissao' => $data['profissao'],
                    'instituicao' => $data['instituicao'],
                    'endereco_id' => $idEndereco['original']['id'],
                ]
        );

        Pessoa::find($id)->edicoes()->attach(['edicao_id' => Edicao::getEdicaoId()],
            ['pessoa_id' => Auth::id()]);


        $comissaoEdicao = DB::table('comissao_edicao')->select('id')
                                    ->where('edicao_id', Edicao::getEdicaoId())
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
                ['edicao_id' => Edicao::getEdicaoId(),
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
                ['edicao_id' => Edicao::getEdicaoId(),
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

	public function homologarComissao($id){

		$comissaoEdicao = DB::table('comissao_edicao')->find($id);
		$pessoa = Pessoa::find($comissaoEdicao->pessoa_id);

		$areasComissao = DB::table('areas_comissao')
			->select('area_id')
			->where('comissao_edicao_id','=',$id)
			->get()
			->toArray();

		$idsAreas = array();
		foreach ($areasComissao as $a)
			array_push($idsAreas, $a->area_id);


		$areas = DB::table('area_conhecimento')->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
			->select('area_conhecimento.id','area_conhecimento.area_conhecimento', 'area_conhecimento.nivel_id')
			->where('area_edicao.edicao_id', Edicao::getEdicaoId())
			->orderBy('area_conhecimento.id', 'asc')
			->get()
			->toArray();

		$nivel = DB::table('nivel')->join('nivel_edicao', 'nivel.id', '=', 'nivel_edicao.nivel_id')
			->select('nivel.nivel', 'nivel.id','nivel_edicao.edicao_id')
			->where('nivel_edicao.edicao_id', Edicao::getEdicaoId())
			->orderBy('nivel.id', 'asc')
			->get()
			->toArray();

        $projetosAreas = DB::table('area_conhecimento')->join('projeto', 'area_conhecimento.id', '=', 'projeto.area_id')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->select('area_conhecimento.area_conhecimento', 'area_conhecimento.id')
            ->where('escola_funcao_pessoa_projeto.edicao_id', Edicao::getEdicaoId())
            ->where('pessoa_id', $comissaoEdicao->pessoa_id)
            ->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::select(['id'])->where('funcao', 'Orientador')->first()->id)
            ->orWhere('escola_funcao_pessoa_projeto.funcao_id', Funcao::select(['id'])->where('funcao', 'Coorientador')->first()->id)
            ->orderBy('area_conhecimento.id', 'asc')
            ->get()
            ->keyBy('id')
            ->toArray();

        $projetosAreas = array_keys($projetosAreas);

        foreach ($areas as $a) {
            if (!in_array($a->id, $projetosAreas)) {
                if(!isset($areasConhecimento)){
                    $areasConhecimento[] = $a;
                }else{
                    $array = array_pluck($areasConhecimento, 'id');
                    if(!in_array($a->id, $array)){
                        $areasConhecimento[] = $a;
                    }
                }
            }
        }

        if ($projetosAreas == null) {
            $areasConhecimento = $areas;
        }

		return view('comissao.homologar', compact('id', 'pessoa', 'idsAreas', 'areas', 'nivel', 'areasConhecimento'));

	}

	public function homologaComissao(Request $req){

		$data = $req->all();

		$areasComissao = DB::table('areas_comissao')
			->select('area_id')
			->where('comissao_edicao_id','=',$data['comissao_edicao_id'])
			->get()
			->toArray();

		$idsAreas = array();
		foreach ($areasComissao as $a)
			array_push($idsAreas, $a->area_id);

        //Existem áreas então HOMOLOGA
		if(isset($data['area_id'])) {

            //Cria novas areas
            $newAreas = array_diff($data['area_id'], $idsAreas);

            foreach ($newAreas as $area => $id) {

                DB::table('areas_comissao')
                    ->insert([
                        'area_id' => $id,
                        'comissao_edicao_id' => $data['comissao_edicao_id'],
                        'homologado' => true
                    ]);
            }

            //Deleta campos que tinham agr não tem mais
            $oldAreas = array_diff($idsAreas, $data['area_id']);
            foreach ($oldAreas as $area => $id) {
                DB::table('areas_comissao')->where([
                    'area_id' => $id,
                    'comissao_edicao_id' => $data['comissao_edicao_id']
                ])->delete();
            }

            //Homologa os campos já existentes
            DB::table('areas_comissao')
                ->select('area_id')
                ->where('comissao_edicao_id', '=', $data['comissao_edicao_id'])
                ->whereIn('area_id', array_intersect($idsAreas, $data['area_id']))
                ->update(['homologado' => true]);

            //Avaliador
            DB::table('funcao_pessoa')
                ->where([
                    'pessoa_id' => $data['pessoa_id'],
                    'edicao_id' => Edicao::getEdicaoId(),
                    'funcao_id' => 3
                ])->update(['homologado' => true]);

            //Homologador
            DB::table('funcao_pessoa')
                ->where([
                    'pessoa_id' => $data['pessoa_id'],
                    'edicao_id' => Edicao::getEdicaoId(),
                    'funcao_id' => 4
                ])->update(['homologado' => true]);


        }else{ //Não existem áreas então NÃO HOMOLOGA

		    //Deleta os campos das areas
            DB::table('areas_comissao')
                ->where(['comissao_edicao_id' => $data['comissao_edicao_id']])
                ->delete();

            //Avaliador
            DB::table('funcao_pessoa')
                ->where([
                    'pessoa_id' => $data['pessoa_id'],
                    'edicao_id' => Edicao::getEdicaoId(),
                    'funcao_id' => 3
                ])->update(['homologado' => false]);

            //Homologador
            DB::table('funcao_pessoa')
                ->where([
                    'pessoa_id' => $data['pessoa_id'],
                    'edicao_id' => Edicao::getEdicaoId(),
                    'funcao_id' => 4
                ])->update(['homologado' => false]);

        }

		return redirect()->route('administrador');
	}

}

