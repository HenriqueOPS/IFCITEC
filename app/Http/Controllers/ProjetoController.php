<?php

namespace App\Http\Controllers;
use App\Http\Controllers\PeriodosController;
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
        $pessoas = Pessoa::all();

        return view('projeto.create')
			->withNiveis($niveis)
			->withAreas($areas)
			->withFuncoes($funcoes)
			->withEscolas($escolas)
			->withPessoas($pessoas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeriodosController $p, ProjetoRequest $request) {
        $projeto = new Projeto();
        $projeto->fill($request->toArray());
        $projeto->titulo = strtoupper($request->titulo);
        //
        $areaConhecimento = AreaConhecimento::find($request->area_conhecimento);
        $nivel = Nivel::find($request->nivel);
        $edicao = Edicao::find($p->periodoInscricao());
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
            $pessoaAutor = DB::table('funcao_pessoa')->select('pessoa_id')
            ->where('funcao_id', $idA->first()->id)->where('edicao_id', $p->periodoInscricao())
            ->where('pessoa_id', $a)->get()->toArray();
            if($pessoaAutor ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $a,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $a,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
             );

            $email = Pessoa::find($a)->email;
            $nome = Pessoa::find($a)->nome;
            Mail::send('mail.mailAutor', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
            $message->to($email);
            $message->subject('IFCITEC');
            });

        }
    }

        $pessoaOrientador = DB::table('funcao_pessoa')->where('funcao_id', $idO->first()->id)->where('edicao_id', $p->periodoInscricao())->where('pessoa_id', $request['orientador'])->get()->toArray();
            if($pessoaOrientador ==  null){
              DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idO->first()->id,
                    'pessoa_id' => $request['orientador'],
                    'homologado' => FALSE
                ]);
            }
                DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idO->first()->id,
                    'pessoa_id' => $request['orientador'],
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
                );
                $email = Pessoa::find($request['orientador'])->email;
                $nome = Pessoa::find($request['orientador'])->nome;
                Mail::send('mail.mailOrientador', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
                $message->to($email);
                $message->subject('IFCITEC');
                });

        foreach($request['coorientador'] as $c){
             if($c != null){
            $pessoaCoorientador = DB::table('funcao_pessoa')->where('funcao_id', $idC->first()->id)->where('edicao_id', $p->periodoInscricao())->where('pessoa_id', $c)->get()->toArray();
            if($pessoaCoorientador ==  false){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $c,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $request->escola,
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $c,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
                );
            $email = Pessoa::find($c)->email;
            $nome = Pessoa::find($c)->nome;
            Mail::send('mail.mailCoorientador', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
            $message->to($email);
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
        $pessoas = Pessoa::all();
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

       
        $idAutor = DB::table('funcao')->select('id')
        ->where('funcao', 'Autor')->get();
        $idOrientador = DB::table('funcao')->select('id')
        ->where('funcao', 'Orientador')->get();
        $idCoorientador = DB::table('funcao')->select('id')
        ->where('funcao', 'Coorientador')->get();

        $autor = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
        ->where('projeto_id', $id)->where('funcao_id', $idAutor->first()->id)->get()->toArray();
        $orientador = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
        ->where('projeto_id', $id)->where('funcao_id', $idOrientador->first()->id)->get()->toArray();
        $coorientador = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
        ->where('projeto_id', $id)->where('funcao_id', $idCoorientador->first()->id)->get()->toArray();
        $niveis = Nivel::all();
        $areas = AreaConhecimento::all();
        $funcoes = Funcao::getByCategory('integrante');
        $escolas = Escola::all();

        return view('projeto.edit', compact('niveis','areas','funcoes','escolas','projetoP','nivelP','areaP','escolaP','palavrasP','autor','orientador','coorientador','pessoas'));
    }

    public function editaProjeto(PeriodosController $p, ProjetoRequest $req){
        $id = $req->all()['id_projeto'];
        Projeto::where('id',$id)->update(['titulo'=>$req->all()['titulo'],
                                         'resumo'=>$req->all()['resumo'],
                                         'area_id'=>$req->all()['area_conhecimento'],
                                         'nivel_id'=>$req->all()['nivel'],


        ]);
        DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->update(['escola_id'=>$req->all()['escola'],
        ]);

        $projeto = Projeto::find($id);
        $palavrasChave = explode(",", $req->all()['palavras_chaves']);
        $palavrasBanco = DB::table('palavra_chave')->join('palavra_projeto', 'palavra_chave.id', '=', 'palavra_projeto.palavra_id')->select('palavra')->where('projeto_id', $id)->get()->keyBy('palavra')->toArray();
        $palavrasb = array_keys( $palavrasBanco);
        for($i=0;$i<count($palavrasChave);$i++){
            $palavrasChave[$i] = trim($palavrasChave[$i]);
        }

        foreach ($palavrasChave as $pc) {
            if(in_array($pc, $palavrasb) == false){
                $projeto->palavrasChaves()->attach(PalavraChave::create(['palavra' => $pc]));
            }
        }

        foreach ($palavrasBanco as $pcbanco) {
            if(! in_array($pcbanco->palavra, $palavrasChave)){
                $idPalavraChave = DB::table('palavra_chave')->join('palavra_projeto', 'palavra_chave.id', '=', 'palavra_projeto.palavra_id')->where('projeto_id', $id)->where('palavra', $pcbanco->palavra)->get();
                DB::table('palavra_projeto')->where('projeto_id', $id)->where('palavra_id',$idPalavraChave->first()->id)->delete();
            }
        }

        $idA = DB::table('funcao')->where('funcao', 'Autor')->get();
        $idO = DB::table('funcao')->where('funcao', 'Orientador')->get();
        $idC = DB::table('funcao')->where('funcao', 'Coorientador')->get();

        $aaProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')->where('projeto_id', $id)->where('edicao_id', $p->periodoInscricao())->where('funcao_id', $idA->first()->id)->get()->keyBy('pessoa_id')->toArray();
        $oProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')->where('projeto_id', $id)->where('edicao_id', $p->periodoInscricao())->where('funcao_id', $idO->first()->id)->get();
        $ccProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')->where('projeto_id', $id)->where('edicao_id', $p->periodoInscricao())->where('funcao_id', $idC->first()->id)->get()->keyBy('pessoa_id')->toArray();
        $aProjeto = array_keys( $aaProjeto);
        $cProjeto = array_keys( $ccProjeto);
        foreach ($aProjeto as $ap) {
          if(in_array($ap, $_POST['autor']) ==  false){
              DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->where('funcao_id', $idA->first()->id)->where('pessoa_id', $ap)->where('edicao_id', $p->periodoInscricao())->delete();
              DB::table('funcao_pessoa')->where('funcao_id', $idA->first()->id)->where('pessoa_id', $ap)->where('edicao_id', $p->periodoInscricao())->delete();
            }
        }
        if($oProjeto->first()->pessoa_id !=  $_POST['orientador']){
              DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->where('funcao_id', $idO->first()->id)->where('pessoa_id', $oProjeto->first()->pessoa_id)->where('edicao_id', $p->periodoInscricao())->delete();
              DB::table('funcao_pessoa')->where('funcao_id', $idO->first()->id)->where('pessoa_id', $oProjeto->first()->pessoa_id)->where('edicao_id', $p->periodoInscricao())->delete();
        }
        if($cProjeto != null){
        foreach ($cProjeto as $cp) {
          if(in_array($cp, $_POST['coorientador']) ==  false){
              DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->where('funcao_id', $idC->first()->id)->where('pessoa_id', $cp)->where('edicao_id', $p->periodoInscricao())->delete();
              DB::table('funcao_pessoa')->where('funcao_id', $idC->first()->id)->where('pessoa_id', $cp)->where('edicao_id', $p->periodoInscricao())->delete();
            }
        }
        }
        foreach($req->all()['autor'] as $a){
            if($a != null){
            if(is_array($aProjeto) == true){
            if(in_array($a, $aProjeto) ==  false){
            $pessoaAutor = DB::table('funcao_pessoa')->select('pessoa_id')
            ->where('edicao_id', $p->periodoInscricao())
            ->where('funcao_id', $idA->first()->id)
            ->where('pessoa_id', $a)->get()->toArray();
            if($pessoaAutor ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $a,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $req->all()['escola'],
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $a,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
             );

            $email = Pessoa::find($a)->email;
             $nome = Pessoa::find($a)->nome;
            Mail::send('mail.mailAutor', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
            $message->to($email);
            $message->subject('IFCITEC');
            });
            }
        }
        else{
            if ($a != $aProjeto->first()->pessoa_id) {
                $pessoaAutor = DB::table('funcao_pessoa')->select('pessoa_id')
                ->where('edicao_id', $p->periodoInscricao())
                ->where('funcao_id', $idA->first()->id)
                ->where('pessoa_id', $a)->get()->toArray();
            if($pessoaAutor ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $a,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $req->all()['escola'],
                    'funcao_id' => $idA->first()->id,
                    'pessoa_id' => $a,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
             );

            $email = Pessoa::find($a)->email;
            $nome = Pessoa::find($a)->nome;
            Mail::send('mail.mailAutor', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
            $message->to($email);
            $message->subject('IFCITEC');
            });
            }
        }
        }
    }
        $orientador = Pessoa::where('id', $oProjeto->first()->pessoa_id) -> first();
        if($req->all()['orientador'] !=  $orientador->id){
        $pessoaOrientador = DB::table('funcao_pessoa')->where('funcao_id', $idO->first()->id)->where('edicao_id', $p->periodoInscricao())->where('pessoa_id', $orientador->first()->id)->get()->toArray();
            if($pessoaOrientador ==  null){
              DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idO->first()->id,
                    'pessoa_id' => $orientador->first()->id,
                    'homologado' => FALSE
                ]);
                }
                DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $req->all()['escola'],
                    'funcao_id' => $idO->first()->id,
                    'pessoa_id' => $orientador->first()->id,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
                );
                $email = Pessoa::find($req->all()['orientador'])->email;
                $nome = Pessoa::find($req->all()['orientador'])->nome;
                Mail::send('mail.mailOrientador', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
                $message->to($email);
                $message->subject('IFCITEC');
                });
            }
        foreach($req->all()['coorientador'] as $c){
            if($c != null){
            if(is_array($cProjeto) == true){
            if(in_array($c, $cProjeto) ==  false){
            $pessoaCoorientador = DB::table('funcao_pessoa')->where('funcao_id', $idC->first()->id)->where('edicao_id', $p->periodoInscricao())->where('pessoa_id', $c)->get()->toArray();
            if($pessoaCoorientador ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $c,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $req->all()['escola'],
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $c,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
                );
            $email = Pessoa::find($c)->email;
            $nome = Pessoa::find($c)->nome;
            Mail::send('mail.mailCoorientador', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
            $message->to($email);
            $message->subject('IFCITEC');
            });
            }
            }
            else{
            if (count($cProjeto) == 0 || $c != $cProjeto->first()->pessoa_id) {
                $pessoaCoorientador = DB::table('funcao_pessoa')->where('funcao_id', $idC->first()->id)->where('edicao_id', $p->periodoInscricao())->where('pessoa_id', $c)->get()->toArray();
            if($pessoaCoorientador ==  null){
            DB::table('funcao_pessoa')->insert(
                ['edicao_id' => $p->periodoInscricao(),
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $c,
                    'homologado' => FALSE
                ]);
            }
            DB::table('escola_funcao_pessoa_projeto')->insert(
                ['escola_id' => $req->all()['escola'],
                    'funcao_id' => $idC->first()->id,
                    'pessoa_id' => $c,
                    'projeto_id' => $projeto->id,
                    'edicao_id' => $p->periodoInscricao(),
                ]
                );
            $email = Pessoa::find($c)->email;
            $nome = Pessoa::find($c)->nome;
            Mail::send('mail.mailCoorientador', ['projeto'=>$projeto, 'nome' => $nome], function($message) use ($email){
            $message->to($email);
            $message->subject('IFCITEC');
            });
            }
            }
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
