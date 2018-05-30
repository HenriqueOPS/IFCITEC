<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjetoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
//
use App\Nivel;
use App\AreaConhecimento;
use App\Funcao;
use App\Escola;
use App\Edicao;
use App\Projeto;
use App\Pessoa;
use App\PalavraChave;
use App\Revisao;
use App\Avaliacao;

class ProjetoController extends Controller {

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        //$this->middleware('checkAuthorship', ['only' => 'show']);
        //$this->middleware('isOrganizacao', ['only' => 'create']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $niveis = Nivel::all();
        $areas = AreaConhecimento::all();
        $funcoes = Funcao::getByCategory('integrante');
        $escolas = Escola::all();
        return view('projeto.create')->withNiveis($niveis)->withAreas($areas)->withFuncoes($funcoes)->withEscolas($escolas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjetoRequest $request) {
        $projeto = new Projeto();
        $projeto->fill($request->toArray());
        $projeto->titulo = strtoupper($request->titulo);
        //
        $areaConhecimento = AreaConhecimento::find($request->area_conhecimento);
        $nivel = Nivel::find($request->nivel);
        $edicao = Edicao::find(2); // EDICAO CORRENTE
        $projeto->areaConhecimento()->associate($areaConhecimento);
        $projeto->nivel()->associate($nivel);
        $projeto->edicao()->associate($edicao);
        //
        $projeto->save();
        //--Inicio Attachment de Palavras Chaves. Tabela: palavra_projeto
        $palavrasChaves = explode(",", $request->palavras_chaves);
        foreach ($palavrasChaves as $palavra) {
            $projeto->palavrasChaves()->attach(PalavraChave::create(['palavra' => $palavra]));
        }

        //--Inicio Attachment de Participante. 
        //Tabela: funcao_pessoa 
        //Tabela: escola_funcao_pessoa_projeto
        //Insert via DB pois o Laravel não está preparado para um tabela de 4 relacionamentos
    
        $idA = DB::table('funcao')->where('funcao', 'Autor')->get();
        $idO = DB::table('funcao')->where('funcao', 'Orientador')->get();
        $idC = DB::table('funcao')->where('funcao', 'Coorientador')->get();
        
        foreach($request['autor'] as $a){
            

            if($a != null){     
            $autor = DB::table('pessoa')->where('email', $a)->get();
            $pessoaAutor = DB::table('funcao_pessoa')->select('pessoa_id')
            ->where('funcao_id', $idA->first()->id)
            ->where('pessoa_id', $autor->first()->id)->get()->toArray();
            if($pessoaAutor ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 2, //pegar edição corrente
                    'funcao_id' => $idA->first()->id, 
                    'pessoa_id' => $autor->first()->id,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $autor->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => 2, //pegar edição corrente
                ]
             );

            Mail::send('mail.mailAutor', ['projeto'=>$projeto], function($message) use ($a){
            $message->to($a);
            $message->subject('IFCITEC');
            });
    
        }
    }

        $orientador = DB::table('pessoa')->where('email', $request['orientador'])->get();
        $pessoaOrientador = DB::table('funcao_pessoa')->where('funcao_id', $idO->first()->id)->where('pessoa_id', $orientador->first()->id)->get()->toArray();
            if($pessoaOrientador ==  null){
              DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 2, //pegar edição corrente
                    'funcao_id' => $idO->first()->id, 
                    'pessoa_id' => $orientador->first()->id,
                    'homologado' => FALSE
                ]);
            }
                DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idO->first()->id,
                    'pessoa_id' => $orientador->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => 2, //pegar edição corrente
                ]
                );
                $email = $request['orientador'];
                Mail::send('mail.mailOrientador', ['projeto'=>$projeto], function($message) use ($email){
                $message->to($email);
                $message->subject('IFCITEC');
                });
        
        foreach($request['coorientador'] as $c){
             if($c != null){
            $coorientador = DB::table('pessoa')->where('email', $c)->get();
            $pessoaCoorientador = DB::table('funcao_pessoa')->where('funcao_id', $idC->first()->id)->where('pessoa_id', $coorientador->first()->id)->get()->toArray();
            if($pessoaCoorientador ==  false){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 2, //pegar edição corrente
                    'funcao_id' => $idC->first()->id, 
                    'pessoa_id' => $coorientador->first()->id,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $coorientador->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => 2, //pegar edição corrente
                ]
                );
            Mail::send('mail.mailCoorientador', ['projeto'=>$projeto], function($message) use ($c){
            $message->to($c);
            $message->subject('IFCITEC');
            });
            }
        }
    
        return redirect()->route('projeto.show', ['projeto' => $projeto->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $projeto = Projeto::find($id);
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        return view('projeto.show')->withProjeto($projeto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editarProjeto($id) {    
        $projetoP = Projeto::find($id);  
        $nivelP = Nivel::find($projetoP->nivel_id);
        $areaP = AreaConhecimento::find($projetoP->area_id);
        $idPalavras = DB::table('palavra_projeto')->select('palavra_id')
            ->where('projeto_id', $id)->get();
        foreach ($idPalavras as $i) {
            $palavrasP[] = PalavraChave::find($i->palavra_id);
        }
        $escolaP = DB::table('escola_funcao_pessoa_projeto')->select('escola_id')
        ->where('projeto_id', $id)->get();

        //pega o id das funções
        $idAutor = DB::table('funcao')->select('id')
        ->where('funcao', 'Autor')->get();
        $idOrientador = DB::table('funcao')->select('id')
        ->where('funcao', 'Orientador')->get();
        $idCoorientador = DB::table('funcao')->select('id')
        ->where('funcao', 'Coorientador')->get();

        //pega as funções no projeto
        $autor = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
        ->where('projeto_id', $id)->where('funcao_id', $idAutor->first()->id)->get();
        $orientador = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
        ->where('projeto_id', $id)->where('funcao_id', $idOrientador->first()->id)->get();
        $coorientador = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
        ->where('projeto_id', $id)->where('funcao_id', $idCoorientador->first()->id)->get();
        //email dos participantes
        foreach ($autor as $a) {
             $autorP = DB::table('pessoa')->select('email')
            ->where('id', $a->pessoa_id)->get();
        }
        $orientadorP = DB::table('pessoa')->where('id', $orientador->first()->pessoa_id)->get();
        $cont = 0;
        foreach ($coorientador as $c) {
             $coorientadorP = DB::table('pessoa')->select('email')
            ->where('id', $c->pessoa_id)->get();
            $cont = 1;
        }
        if($cont!=1){
            $coorientadorP = collect([null, null]);
        }
        $niveis = Nivel::all();
        $areas = AreaConhecimento::all();
        $funcoes = Funcao::getByCategory('integrante');
        $escolas = Escola::all();

        return view('projeto.edit', compact('niveis','areas','funcoes','escolas','projetoP','nivelP','areaP','escolaP','palavrasP','autor','orientador','coorientador','autorP','orientadorP','coorientadorP'));
    }

    public function editaProjeto(ProjetoRequest $req){
        $id = $req->all()['id_projeto'];
        Projeto::where('id',$id)->update(['titulo'=>$req->all()['titulo'],
                                         'resumo'=>$req->all()['resumo'],
                                         'area_id'=>$req->all()['area_id'],
                                         'nivel_id'=>$req->all()['nivel_id'],
                                         

        ]);
        
        DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->update(['escola_id'=>$req->all()['escola'],
        ]);

        $idA = DB::table('funcao')->where('funcao', 'Autor')->get();
        $idO = DB::table('funcao')->where('funcao', 'Orientador')->get();
        $idC = DB::table('funcao')->where('funcao', 'Coorientador')->get();

        $aProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')->where('projeto_id', $id)->where('funcao_id', $idA->first->id)->get();
        $oProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')->where('projeto_id', $id)->where('funcao_id', $idO->first->pessoa_id)->get();
        $cProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')->where('projeto_id', $id)->where('funcao_id', $idC->first->id)->get();
        
        foreach($request['autor'] as $a){
            if($a != null){     
            if(in_array($a, $aProjeto) ==  false){          
            $autor = DB::table('pessoa')->where('email', $a)->get();
            $pessoaAutor = DB::table('funcao_pessoa')->select('pessoa_id')
            ->where('funcao_id', $idA->first()->id)
            ->where('pessoa_id', $autor->first()->id)->get()->toArray();
            if($pessoaAutor ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 2, //pegar edição corrente
                    'funcao_id' => $idA->first()->id, 
                    'pessoa_id' => $autor->first()->id,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $autor->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => 2, //pegar edição corrente
                ]
             );

            Mail::send('mail.mailAutor', ['projeto'=>$projeto], function($message) use ($a){
            $message->to($a);
            $message->subject('IFCITEC');
            });
            }
        }
        }

        if($request['autor'] !=  $oProjeto){   
        $orientador = DB::table('pessoa')->where('email', $request['orientador'])->get();
        $pessoaOrientador = DB::table('funcao_pessoa')->where('funcao_id', $idO->first()->id)->where('pessoa_id', $orientador->first()->id)->get()->toArray();
            if($pessoaOrientador ==  null){
              DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 2, //pegar edição corrente
                    'funcao_id' => $idO->first()->id, 
                    'pessoa_id' => $orientador->first()->id,
                    'homologado' => FALSE
                ]);
            }
                DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idO->first()->id,
                    'pessoa_id' => $orientador->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => 2, //pegar edição corrente
                ]
                );
                $email = $request['orientador'];
                Mail::send('mail.mailOrientador', ['projeto'=>$projeto], function($message) use ($email){
                $message->to($email);
                $message->subject('IFCITEC');
                });
            }
        
        foreach($request['coorientador'] as $c){
             if($c != null){
            if(in_array($c, $cProjeto) ==  false){ 
            $coorientador = DB::table('pessoa')->where('email', $c)->get();
            $pessoaCoorientador = DB::table('funcao_pessoa')->where('funcao_id', $idC->first()->id)->where('pessoa_id', $coorientador->first()->id)->get()->toArray();
            if($pessoaCoorientador ==  false){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => 2, //pegar edição corrente
                    'funcao_id' => $idC->first()->id, 
                    'pessoa_id' => $coorientador->first()->id,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $coorientador->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => 2, //pegar edição corrente
                ]
                );
            Mail::send('mail.mailCoorientador', ['projeto'=>$projeto], function($message) use ($c){
            $message->to($c);
            $message->subject('IFCITEC');
            });
            }
        }
        }

        foreach ($aProjeto as $ap) {
          if(in_array($ap, $_POST['autor']) ==  false){
              DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->where('funcao_id', $idA->first->id)->where('pessoa_id', $ap->id)->delete();
            }
        }
        if($oProjeto !=  $_POST['orientador']){
              DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->where('funcao_id', $idO->first->id)->where('pessoa_id', $oProjeto->pessoa_id)->delete();
        }
        foreach ($cProjeto as $cp) {
          if(in_array($cp, $_POST['coorientador']) ==  false){
              DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->where('funcao_id', $idC->first->id)->where('pessoa_id', $cp->pessoa_id)->delete();
            }
        }
        return redirect()->route('projeto.show', ['projeto' => $projeto->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function integrantes($id) {
        $projeto = Projeto::find($id);
        //É necessário um refact neste bloco:
        //Bloqueando roles no projeto conforme regulamento
        $funcoes = Funcao::getByCategory('integrante');
        $totalFuncoes = $projeto->getTotalFuncoes($funcoes);
        if($totalFuncoes['Autor'] >= 3){
            unset($funcoes[0]);
        }
         if($totalFuncoes['Coorientador'] >= 2){
            unset($funcoes[1]);
        }
         if($totalFuncoes['Orientador'] >= 1){
            unset($funcoes[2]);
        }
        
        //Fim do refact necessário
        $escolas = Escola::all();
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        return view('projeto.integrantes')->withProjeto($projeto)->withFuncoes($funcoes)->withEscolas($escolas);
    }

    public function vinculaIntegrante(Request $request) {
        //Insert via DB pois o Laravel não está preparado para um tabela de 4 relacionamentos
        DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $request->funcao,
                    'pessoa_id' => $request->pessoa,
                    'projeto_id' => $request->projeto
                ]
        );
        
        return redirect()->route('projeto.show', ['projeto' =>$request->projeto]);
    }

    public function showFormVinculaRevisor($id){
        $projeto = Projeto::find($id);
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        $revisores = (DB::table('revisoresview')->select('*')->orderBy('titulacao')->get());
       // $revisores = (Pessoa::whereFuncao('Revisor')->orderBy('titulacao')->get());

        return view('organizacao.vinculaRevisor')
            ->withRevisores($revisores)
            ->withProjeto($projeto);
    }

    public function vinculaRevisor(Request $request){
        DB::table('revisao')->where('projeto_id', '=', $request->projeto_id)->delete();
        $revisao = new Revisao();
        $revisao->projeto_id = $request->projeto_id;
        $revisao->pessoa_id =  $request->revisor_id;
        $revisao->situacao_id =  4;
        $revisao->save();

        return redirect('home');
    }

    public function showFormVinculaAvaliador($id)
    {
        $projeto = Projeto::find($id);
        if (!($projeto instanceof Projeto)) {
            abort(404);
        }
        $avaliadores = (DB::table('avaliadoresview')->select('*')->get());
        // $revisores = (Pessoa::whereFuncao('Revisor')->orderBy('titulacao')->get());

        $avaliadoresDoProjeto = DB::table('avaliacao')->select('pessoa_id')->where('projeto_id', '=', $id)->get();

        $avaliadoresValue = "";
        foreach ($avaliadoresDoProjeto as $avaliador) {
            //dd($avaliador);
            $avaliadoresValue .= ',' . $avaliador->pessoa_id;
        }
        $avaliadoresValue = ltrim($avaliadoresValue, ',');

        return view('organizacao.vinculaAvaliador')
            ->with(["avaliadores" => $avaliadores,
                "avaliadoresValue" => $avaliadoresValue,
                "projeto" => $projeto,
            ]);
    }

    public function vinculaAvaliador(Request $request){
        DB::table('avaliacao')->where('projeto_id', '=', $request->projeto_id)->delete();
        $avaliadores = explode(',',$request->avaliadores_id);
        foreach ($avaliadores as $avaliador){
            $avaliacao = new Avaliacao();
            $avaliacao->pessoa_id = $avaliador;
            $avaliacao->projeto_id = $request->projeto_id;
            $avaliacao->nota_final = 0;
            $avaliacao->save();
        }

        return redirect('home');
    }

    public function searchPessoaByEmail($email){

        $pessoa = Pessoa::findByEmail($email);
        if (!($pessoa instanceof Pessoa)) {
            return response()->json(['error' => "A pessoa não está inscrita no sistema!"], 200);
        }
         return compact('pessoa');
    }

    public function relatorio($id){
        if($id==1) {
            $resultados = DB::table('public.geral_projetos')->select('*')->get();
            $filename = "GeralProjetos.csv";
        }else if($id==2){
            $resultados = DB::table('public.geralprojetosnotgrouped')->select('*')->get();
            $filename = "GeralProjetosNAOAgrupados.csv";
        }else{
            $resultados = DB::table('public.relatorioavaliadores')->select('*')->get();
            $filename = "Avaliadores.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('ID', 'Nome', 'Email', 'Titulacao', 'Lattes', 'Profissao','Instituicao','CPF','Revisor','Avaliador'));

            foreach($resultados as $row) {
                fputcsv($handle, array($row->id, $row->nome, $row->email, $row->titulacao, $row->lattes, $row->profissao, $row->instituicao, $row->cpf, $row->revisor, $row->avaliador));
            }

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            return Response::download($filename, $filename, $headers);
        }
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ID', 'Titulo', 'Area Conhecimento', 'Nível', 'Nomes', 'Email','Escola','Situacao'));

        foreach($resultados as $row) {
            fputcsv($handle, array($row->id, $row->titulo, $row->area_conhecimento, $row->nivel, $row->nomes, $row->email, $row->nome_curto, $row->situacao));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers);
    }

    public function setSituacao($id, $situacao){
        $projeto = Projeto::find($id);
        if (!($projeto instanceof Projeto)) {
            return redirect('home');
        }

        foreach ($projeto->revisoes as $revisao){
            $revisao->situacao_id = $situacao;
            $revisao->save();
        }

        return redirect('home');
    }

 //   public function integrantes(){
   //     return view('projeto.integrantes');
   // }
}
