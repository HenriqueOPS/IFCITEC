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
        'titulo', 'resumo', 'relatorio'
    ];

    public function pessoas() {
        return $this->belongsToMany('App\Pessoa', 'escola_funcao_pessoa_projeto')->withPivot('funcao_id');
    }

    public function avaliacoes() {
        return $this->hasMany('App\Avaliacao');
    }

    public function revisoes() {
        return $this->hasMany('App\Revisao');
    }

    public function areaConhecimento() {
        return $this->belongsTo('App\AreaConhecimento', 'area_id');
    }

    public function nivel() {
        return $this->belongsTo('App\Nivel');
    }

    public function palavrasChaves() {
        return $this->belongsToMany('App\PalavraChave', 'palavra_projeto', 'projeto_id', 'palavra_id');
    }

    public function getStatus() {
        $situacao = DB::table('situacao_projeto')->select('situacao')->where('id', '=', $this->id)->orderBy('count', 'desc')->first();
        if(is_null($situacao)){
            return "Não Revisado";
        }else{
            return $situacao->situacao;
        }

    }

    public function getTotalFuncoes($funcoes) {
        foreach ($funcoes as $funcao) {
            $totalFuncoes[$funcao->funcao] = (DB::table('escola_funcao_pessoa_projeto')->where([['projeto_id', $this->id], ['funcao_id', $funcao->id]])->count('funcao_id'));
        }
        return $totalFuncoes;
    }

}
