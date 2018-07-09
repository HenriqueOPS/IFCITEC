<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EdicaoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProjetoRequest;
use Illuminate\Support\Facades\Response;

use App\Edicao;


class EdicaoController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cadastraEdicao(EdicaoRequest $req) {

        //Busca o ano da ultima edição cadastrada no banco
        $query = DB::table('edicao')->select('edicao.ano')
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
        $ano = 0;

        //Incrementa o ano
        if($query->count()>0)
        $ano = ++$query[0]->ano;

        $data = $req->all();
        $data['ano'] = $ano;

        $e = Edicao::create($data);
        if ($e) // foi inserido.
        {
            foreach ($data['nivel_id'] as $i => $nivel)
            	$e->niveis()->attach(['edicao_id' => $e['id']],['nivel_id' => $nivel]);

            foreach ($data['area_id'] as $i => $area)
            	$e->areas()->attach(['edicao_id' => $e['id']],['area_id' => $area]);

        }

        return redirect()->route('administrador');

    }

    public function editarEdicao($id) {

        $nivel = DB::table('nivel_edicao')->select('nivel_id')->where('edicao_id', $id)->get();
        foreach($nivel as $ni)
          $nivelEdicao[] = $ni->nivel_id;


        $area = DB::table('area_edicao')->select('area_id')->where('edicao_id', $id)->get();
        foreach($area as $ai)
          $areaEdicao[] = $ai->area_id;


        $areas = DB::table('area_conhecimento')->select('id','area_conhecimento','nivel_id')->get();
        $niveis = DB::table('nivel')->select('id','nivel')->get();
        $dados = Edicao::find($id);

        return view('admin.editarEdicao',['dados' => $dados,'n' => $niveis,'areas' => $areas,'nivelEdicao' => $nivelEdicao,'areaEdicao' => $areaEdicao]);

    }

    public function editaEdicao(EdicaoRequest $req) {

        $data = $req->all();
        $id = $data['id_edicao'];

        Edicao::find($id)->update([
              'inscricao_abertura'        => $data['inscricao_abertura'],
              'inscricao_fechamento'      => $data['inscricao_fechamento'],
              'homologacao_abertura'      => $data['homologacao_abertura'],
              'homologacao_fechamento'    => $data['homologacao_fechamento'],
              'avaliacao_abertura'        => $data['avaliacao_abertura'],
              'avaliacao_fechamento'      => $data['avaliacao_fechamento'],
              'credenciamento_abertura'   => $data['credenciamento_abertura'],
              'credenciamento_fechamento' => $data['credenciamento_fechamento'],
              'voluntario_abertura'       => $data['voluntario_abertura'],
              'voluntario_fechamento'     => $data['voluntario_fechamento'],
              'comissao_abertura'         => $data['comissao_abertura'],
              'comissao_fechamento'       => $data['comissao_fechamento'],
			  'feira_abertura'         	  => $data['feira_abertura'],
			  'feira_fechamento'      	  => $data['feira_fechamento']
            ]);

        $nivel = DB::table('nivel_edicao')->select('nivel_id')->where('edicao_id', $id)->get();

        foreach($nivel as $ni){
          $nivelEdicao[] = $ni->nivel_id;
        }

        $area = DB::table('area_edicao')->select('area_id')->where('edicao_id', $id)->get();
        foreach($area as $ai){
          $areaEdicao[] = $ai->area_id;
        }

        foreach ($data['nivel_id'] as $n) {
            if(!in_array($n, $nivelEdicao))
              DB::table('nivel_edicao')->insert(['edicao_id' => $id,'nivel_id' => $n]);
        }

        foreach ($nivelEdicao as $n) {
          if(!in_array($n, $data['nivel_id']))
              DB::table('nivel_edicao')->where('nivel_id', $n)->where('edicao_id', $id)->delete();
        }

        foreach ($data['area_id'] as $a) {
            if(!in_array($a, $areaEdicao))
              DB::table('area_edicao')->insert(['edicao_id' => $id,'area_id' => $a]);
        }

        foreach ($areaEdicao as $a) {
          if(!in_array($a, $data['area_id']))
              DB::table('area_edicao')->where('area_id', $a)->where('edicao_id', $id)->delete();
        }

        return redirect()->route('administrador');
    }

    //Retorna os dados de uma determinada edição
    public function edicao($id)
    {

        $query = DB::table('edicao')->select('edicao.ano')
            ->where('id','=',$id)
            ->get();
        $ano = $query[0]->ano;

        $niveis = DB::table('nivel')->select('nivel.*')
            ->where('edicao_id','=',$id)
            ->get();


        return view('admin.homeEdicao', collect([
                                                'ano' => $ano,
                                                'id' => $id,
                                                'projetos' => '',
                                                'areas' => '',
                                                'niveis' => $niveis
                                                ]));
    }

    public function cadastroEdicao()
    {
        $niveis = DB::table('nivel')->select('id','nivel')->get();
        $areas = DB::table('area_conhecimento')->select('id','area_conhecimento','nivel_id')->get();
        return view('admin.cadastroEdicao', array('niveis' => $niveis), array('areas' =>
            $areas));
    }

    public function dadosEdicao($id) { //Ajax

      $dados = Edicao::find($id);
      $nivelEdicao = DB::table('nivel_edicao')->select('nivel_id')->where('edicao_id', $id)->get();
      $areaEdicao = DB::table('area_edicao')->select('area_id')->where('edicao_id', $id)->get();
      $nivel = DB::table('nivel')->select('id','nivel')->get();
      $area = DB::table('area_conhecimento')->select('id','area_conhecimento', 'nivel_id')->get();

      return compact('dados','nivelEdicao','nivel','area','areaEdicao');
    }

    public function excluiEdicao($id, $s){

      if(password_verify($s, Auth::user()['attributes']['senha'])){

          $e = Edicao::find($id);

          DB::table('nivel_edicao')->where('edicao_id', $id)->delete();
          DB::table('area_edicao')->where('edicao_id', $id)->delete();
          DB::table('funcao_pessoa')->where('edicao_id', $id)->delete();
          Edicao::find($id)->delete();

          return 'true';
      }

      return 'false';
    }
}


