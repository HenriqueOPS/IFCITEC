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
        return $this->hasMany('App\Avaliacao');
    }

    public function revisoes() {
        return $this->hasMany('App\Revisao');
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

    /*
     *
     * Retorna TRUE quando todos homologadores já tiverem avaliado o projeto
     *
     */
    public function statusHomologacao(){

        $homologadores = DB::table('revisao')
            ->select('revisado')
            ->where('projeto_id','=',$this->id)
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

    public function statusAvaliacao(){

        $avaliadores = DB::table('avaliacao')
            ->select('avaliado')
            ->where('projeto_id','=',$this->id)
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

    public function getTotalFuncoes($funcoes) {
        foreach ($funcoes as $funcao) {
            $totalFuncoes[$funcao->funcao] = (DB::table('escola_funcao_pessoa_projeto')->where([['projeto_id', $this->id], ['funcao_id', $funcao->id]])->count('funcao_id'));
        }
        return $totalFuncoes;
    }



}
