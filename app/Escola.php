<?php

namespace App;

use App\Mods\Model;
use App\Projeto;
use App\Pessoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Escola extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escola';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome_completo', 'nome_curto', 'email', 'moodle_link', 'moodle_versao'
    ];

    public function getPessoas() {
        //REFACT 
        //NOTE: Infelizmente o laravel não possui suporte para a cláusula DISTINCT ON. 
        //Futuramente uma issue será aberta na tentativa de solução do problema
        $query = DB::table('pessoa')->select('pessoa.*')
                ->join('escola_funcao_pessoa_projeto', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
                ->leftJoin('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
                ->where('escola.id', $this->id)
                ->distinct()
                ->orderBy('pessoa.id');

        $eloquent = new Builder($query);

        $eloquent->setModel(new Pessoa);

        return $eloquent->get();

        //return $this->belongsToMany('App\Pessoa', 'escola_funcao_pessoa_projeto')->withPivot('projeto_id', 'funcao_id');
    }

    public function getProjetos() {
         //REFACT 
        //NOTE: Infelizmente o laravel não possui suporte para a cláusula DISTINCT ON. 
        //Futuramente uma issue será aberta na tentativa de solução do problema
        $query = DB::table('projeto')->select('projeto.*')
                ->join('escola_funcao_pessoa_projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
                ->leftJoin('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
                ->where('escola.id', $this->id)
                ->distinct()
                ->orderBy('projeto.id');

        $eloquent = new Builder($query);
        $eloquent->setModel(new Projeto);

        return $eloquent->get();
    }
    
    public function projetos(){
         return $this->belongsToMany('App\Projeto', 'escola_funcao_pessoa_projeto');
    }
    
    public function scopeTemMoodle($query){
        return $query->where('moodle_link','<>',null);
    }

}
