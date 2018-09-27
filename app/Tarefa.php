<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

class Tarefa extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tarefa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tarefa', 'descricao', 'vagas'
    ];
    
    public function pessoas() {
        return $this->belongsToMany('App\Pessoa', 'pessoa_tarefa','tarefa_id','pessoa_id');
    }

    public function pessoasTarefa($id){
        $pessoas = Pessoa::select('pessoa.id', 'pessoa.nome')
            ->join('pessoa_tarefa', 'pessoa.id', '=', 'pessoa_tarefa.pessoa_id')
            ->where('pessoa_tarefa.edicao_id','=',Edicao::getEdicaoId())
            ->where('pessoa_tarefa.tarefa_id','=',$id)
            ->get();
        
        return $pessoas->count();
    }
    


}
