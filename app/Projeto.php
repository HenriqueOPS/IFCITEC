<?php

namespace App;

use App\Mods\Model;
//
use Illuminate\Support\Facades\DB;

class Projeto extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projeto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo', 'resumo', 'relatorio', 'situacao_id', 'presenca'
    ];

    public function pessoas() {
        return $this->belongsToMany('App\Pessoa', 'escola_funcao_pessoa_projeto')
			->withPivot('funcao_id', 'escola_id');
    }

    public function avaliacoes() {
        return $this->hasMany('App\Avaliacao', 'projeto_id');
    }

    public function revisoes() {
        return $this->hasMany('App\Revisao', 'projeto_id');
    }

    public function areaConhecimento() {
        return $this->belongsTo('App\AreaConhecimento', 'area_id');
    }

    public function nivel() {
        return $this->belongsTo('App\Nivel','nivel_id');
    }

    public function edicao() {
        return $this->belongsTo('App\Edicao', 'edicao_id');
    }

    public function palavrasChaves() {
        return $this->belongsToMany('App\PalavraChave', 'palavra_projeto', 'projeto_id', 'palavra_id');
    }

    public function getStatus() {

        $situacao = DB::table('situacao')
            ->select('situacao')
            ->where('id', '=', $this->situacao_id)
            ->first();

        if (!is_null($situacao))
            return $situacao->situacao;

        return "Cadastrado"; // XGH
    }

    public function getNotaRevisao($id){
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projeto = Projeto::select(DB::raw('('.$subQuery.') as nota'))
            ->join('situacao','projeto.situacao_id','=','situacao.id')
            ->where('edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.id','=',$id)
            ->get();
        return $projeto->first()->nota;
    }

    public function getNotaAvaliacao($id){
        $subQuery = DB::table('avaliacao')
            ->select(DB::raw('COALESCE(AVG(avaliacao.nota_final),0)'))
            ->where('avaliacao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projeto = Projeto::select(DB::raw('('.$subQuery.') as nota'))
            ->join('situacao','projeto.situacao_id','=','situacao.id')
            ->where('edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.id','=',$id)
            ->get();

        return $projeto->first()->nota;
    }

    /*
     *
     * Retorna TRUE quando todos homologadores já tiverem avaliado o projeto
     *
     */
    public function statusHomologacao(){

        $homologadores = DB::table('revisao')
            ->select('revisado')
            ->where('projeto_id', '=', $this->id)
            ->get()
            ->toArray();

        $count = 0;

        foreach ($homologadores as $homologador){
            if($homologador->revisado)
                $count++;
        }

        if($count == count($homologadores) && count($homologadores) != 0)
            return true;

        return false;
    }

	/*
	 *
	 * Retorna TRUE quando todos avaliadores já tiverem avaliado o projeto
	 *
	 */
    public function statusAvaliacao(){

        $avaliadores = DB::table('avaliacao')
            ->select('avaliado')
            ->where('projeto_id', '=', $this->id)
            ->get()
            ->toArray();

        $count = 0;

        foreach ($avaliadores as $avaliador){
            if($avaliador->avaliado)
                $count++;
        }

        if($count == count($avaliadores) && count($avaliadores) != 0)
            return true;

        return false;
    }

    public function statusPresenca(){
        $projeto = Projeto::select('presenca')
            ->where('id','=', $this->id)
            ->get();
        if($projeto->count() && $projeto[0]->presenca != null)
            return true;

        return false;
    }

    public function getTotalFuncoes($funcoes) {
        foreach ($funcoes as $funcao) {
            $totalFuncoes[$funcao->funcao] = (DB::table('escola_funcao_pessoa_projeto')->where([['projeto_id', $this->id], ['funcao_id', $funcao->id]])->count('funcao_id'));
        }
        return $totalFuncoes;
    }


    public function getAutores() {
        $autores = DB::table('pessoa')
			->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->where('escola_funcao_pessoa_projeto.projeto_id', $this->id)
			->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Autor')->get()->first()->id)
			->orderBy('pessoa.nome')
			->get();

        return $autores;
    }

    public function getOrientador() {
        $orientador = DB::table('pessoa')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
			->where('escola_funcao_pessoa_projeto.projeto_id', $this->id)
			->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Orientador')->get()->first()->id)
			->orderBy('pessoa.nome')
			->get();

        return $orientador;
    }

    public function getCoorientadores() {
        $coorientadores = DB::table('pessoa')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
			->where('escola_funcao_pessoa_projeto.projeto_id', $this->id)
			->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Coorientador')->get()->first()->id)
			->orderBy('pessoa.nome')
			->get();

        return $coorientadores;
    }


}
