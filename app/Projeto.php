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
        'titulo', 'resumo', 'relatorio', 'situacao_id'
    ];

    public function pessoas() {
        return $this->belongsToMany('App\Pessoa', 'escola_funcao_pessoa_projeto')->withPivot('funcao_id', 'escola_id');
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

        if(!is_null($situacao)){
            return $situacao->situacao;
        }

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
           // ->where('situacao.situacao','=','Homologado')
            ->get();
        return $projeto->first()->nota;
    }

    public function getTotalFuncoes($funcoes) {
        foreach ($funcoes as $funcao) {
            $totalFuncoes[$funcao->funcao] = (DB::table('escola_funcao_pessoa_projeto')->where([['projeto_id', $this->id], ['funcao_id', $funcao->id]])->count('funcao_id'));
        }
        return $totalFuncoes;
    }

}
