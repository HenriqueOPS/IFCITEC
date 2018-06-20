<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Funcao;
use App\Edicao;
use App\Escola;
use App\Endereco;
use App\Nivel;
use App\AreaConhecimento;
use Illuminate\Http\Request;
use App\Http\Requests\NivelRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

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
        //$this->middleware('isAdministrador');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PeriodosController $p)
    {
        $edicoes = DB::table('edicao')->select('edicao.*')->get();

        $niveis = DB::table('nivel')->select('nivel.*')
                                    ->orderBy('nivel', 'asc')->get();

        $areas = DB::table('area_conhecimento')
			->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
			->select('area_conhecimento.id', 'area_conhecimento', 'area_conhecimento.descricao','nivel_id')
            ->orderBy('area_conhecimento', 'asc')->get();

        /*$escolas = DB::table('escola')->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
                                      ->select('escola.id', 'nome_completo', 'nome_curto', 'email',
                                      'telefone', 'municipio')
                                      ->orderBy('nome_curto', 'asc')
                                      ->get();*/

        $escolas = DB::table('escola')
			->select('escola.id', 'nome_completo', 'nome_curto', 'email', 'telefone')
            ->orderBy('nome_curto', 'asc')->get();
        /*
        $projetos = DB::table('projeto')
                                      ->select('titulo','id')
                                      ->where('edicao_id', $p->periodoInscricao())
                                      ->orderBy('created_at', 'asc')
                                      ->get()
                                      ->keyBy('id')
                                      ->toArray();

      //Participantes dos projetos

        if($projetos){
        $idAutor =  Funcao::where('funcao','Autor')-> first();
        $idOrientador =  Funcao::where('funcao','Orientador')-> first();
        $idCoorientador =  Funcao::where('funcao','Coorientador')-> first();

        $ids = array_keys( $projetos);

        $autor = DB::table('escola_funcao_pessoa_projeto')->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')->whereIn('projeto_id', $ids)->where('funcao_id', $idAutor->id)->get()->toArray();
        $orientador = DB::table('escola_funcao_pessoa_projeto')->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')->whereIn('projeto_id', $ids)->where('funcao_id', $idOrientador->id)->get()->toArray();
        $coorientador = DB::table('escola_funcao_pessoa_projeto')->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')->select('escola_funcao_pessoa_projeto.projeto_id','pessoa.id','pessoa.nome')->whereIn('projeto_id', $ids)->where('funcao_id', $idCoorientador->id)->get()->toArray();
        }
        else{
            $autores = (array) null;
            $orientador = null;
            $coorientadores = (array) null;
        }
        if(! isset($coorientadores)){
            $coorientadores = (array) null;
        }



        return view('admin.home', collect(['edicoes' => $edicoes, 'enderecos' => $enderecos, 'escolas' => $escolas, 'niveis' => $niveis, 'areas' => $areas, 'projetos' => $projetos, 'autor' => $autor, 'orientador' => $orientador, 'coorientador' => $coorientador]));
		*/

        $projetos = array();

		return view('admin.home', collect(['edicoes' => $edicoes,
												 'escolas' => $escolas,
												 'niveis' => $niveis,
												 'areas' => $areas,
												 'projetos' => $projetos
												]));

	}


    public function dadosNivel($id) { //Ajax
      $dados = Nivel::find($id);
      return compact('dados');
    }

    public function cadastroNivel() {
        return view('admin.cadastroNivel');
    }


    public function cadastraNivel(NivelRequest $req){

        $data = $req->all();

        Nivel::create([
                    'nivel' => $data['nivel'],
                    'descricao' => $data['descricao'],
                    'max_ch' => $data['max_ch'],
                    'min_ch' => $data['min_ch'],
                    'palavras' => $data['palavras'],
                  ]);

        return redirect()->route('administrador');

    }

    public function editarNivel($id) {
        $dados = Nivel::find($id);

        return view('admin.editarNivel', compact('dados'));
    }

    public function editaNivel(NivelRequest $req) {

        $data = $req->all();
        $id = $data['id_nivel'];

        Nivel::where('id',$id)
			->update(['nivel'     => $data['nivel'],
					  'max_ch'    => $data['max_ch'],
					  'min_ch'    => $data['min_ch'],
					  'descricao' => $data['descricao'],
					  'palavras'  => $data['palavras'],
					]);

        return redirect()->route('administrador');
    }

    public function excluiNivel($id, $s){

      if(password_verify($s, Auth::user()['attributes']['senha'])){
          Nivel::find($id)->delete();

          return 'true';
      }

      return 'false';
    }

    public function dadosArea($id) { //Ajax

      $dados = AreaConhecimento::find($id);
      $data = Nivel::find($dados->nivel_id);

      return compact('dados','data');
    }

    public function cadastroArea() {
        $niveis = DB::table('nivel')->select('id','nivel')->get();

        return view('admin.cadastroArea', array('niveis' => $niveis));
    }

    public function cadastraArea(Request $req){

        $data = $req->all();

        AreaConhecimento::create([
                    'nivel_id' => $data['nivel_id'],
                    'area_conhecimento' => $data['area_conhecimento'],
                    'descricao' => $data['descricao'],
                  ]);

        return redirect()->route('administrador');

    }

    public function editarArea($id) {
        $niveis = DB::table('nivel')->select('id','nivel')->get();
        $dados = AreaConhecimento::find($id);

        return view('admin.editarArea', array('niveis' => $niveis), compact('dados'));
    }

    public function editaArea(Request $req) {

    	$data = $req->all();

        $id = $data['id_area'];

        AreaConhecimento::where('id',$id)
			->update(['nivel_id'=>$data['nivel_id'],
                      'area_conhecimento'=>$data['area_conhecimento'],
					  'descricao'=>$data['descricao']
					]);

        return redirect()->route('administrador');
    }

    public function excluiArea($id, $s){
      if(password_verify($s, Auth::user()['attributes']['senha'])){
          AreaConhecimento::find($id)->delete();
          return 'true';
      }

      return 'false';
    }

    public function dadosEscola($id) { //Ajax

      $dados = Escola::find($id);

      if($dados['endereco_id'])
        $data = Endereco::find($dados['endereco_id']);

      return compact('dados','data');
    }

    public function editarEscola($id) {

      $data = '';
      $dados = Escola::find($id);

      if($dados['endereco_id'])
        $data = Endereco::find($dados['endereco_id']);

      return view('admin.editarEscola', compact('dados','data'));

    }

    public function editaEscola(Request $req) {

        $data = $req->all();

        $id_escola = $data['id_escola'];
        $id_endereco = $data['id_endereco'];

        if($id_endereco != 0){

			Endereco::where('id',$id_endereco)
				->update(['cep' => $data['cep'],
						  'endereco' => $data['endereco'],
						  'bairro' => $data['bairro'],
						  'municipio' => $data['municipio'],
						  'uf' => $data['uf'],
						  'numero' => $data['numero']
						]);

        }else{

			$id_endereco = Endereco::create(['cep' => $data['cep'],
											 'endereco' => $data['endereco'],
											 'bairro' => $data['bairro'],
											 'municipio' => $data['municipio'],
											 'uf' => $data['uf'],
											 'numero' => $data['numero']
										]);

			$id_endereco = $id_endereco['id'];

        }


        Escola::where('id',$id_escola)
			->update(['nome_completo'=> $data['nome_completo'],
					  'nome_curto'=> $data['nome_curto'],
					  'email'=> $data['email'],
					  'telefone'=> $data['telefone'],
					  'endereco_id' => $id_endereco
				     ]);

        return redirect()->route('administrador');
    }

    public function cadastroEscola() {
        return view('admin.cadastroEscola');
    }

    public function cadastraEscola(Request $req){
        $data = $req->all();

        $idEndereco = Endereco::create([
										'cep' => $data['cep'],
										'endereco' => $data['endereco'],
										'bairro' => $data['bairro'],
										'municipio' => $data['municipio'],
										'uf' => $data['uf'],
										'numero' => $data['numero']
									  ]);

        Escola::create([
                    'nome_completo' => $data['nome_completo'],
                    'nome_curto' => $data['nome_curto'],
                    'email' => $data['email'],
                    'telefone' => $data['telefone'],
                    'endereco_id' => $idEndereco['original']['id']
                  ]);

        return redirect()->route('administrador');

    }

    public function excluiEscola($id, $s){

      if(password_verify($s, Auth::user()['attributes']['senha'])){
          Escola::find($id)->delete();

          return 'true';
      }

      return 'false';
    }

    public function administrarUsuarios(){
        return view('admin.administrarUsuarios');
    }

}
