<?php

namespace App;

use App\Mods\Model;
use App\Pessoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Funcao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'funcao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'funcao', 'descricao', 'sistema', 'integrante', 'projeto'
    ];

    public function pessoaFuncao(){

	}


    public function pessoas() {
        return $this->belongsToMany('App\Pessoa', 'funcao_pessoa');
    }

    public function getPessoasProjeto() {
        //REFACT
        //NOTE: Infelizmente o laravel não possui suporte para a cláusula DISTINCT ON.
        //Futuramente uma issue será aberta na tentativa de solução do problema
        $query = DB::table('pessoa')->select('pessoa.*')
                ->join('escola_funcao_pessoa_projeto', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
                ->leftJoin('funcao', 'escola_funcao_pessoa_projeto.funcao_id', '=', 'funcao.id')
                ->where('funcao.id', $this->id)
                ->distinct()
                ->orderBy('pessoa.id');

        $eloquent = new Builder($query);

        $eloquent->setModel(new Pessoa);

        return $eloquent->get();

        // return $this->belongsToMany('App\Pessoa','escola_funcao_pessoa_projeto');
    }

    static function getByCategory($category){
        return Funcao::where($category, true)->get();
    }

}
