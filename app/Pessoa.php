<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\SchemaObservable as SchemaObservable;

class Pessoa extends Authenticatable {
    use SchemaObservable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pessoa';
    
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $schema = 'public';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'senha', 'cpf', 'dt_nascimento', 'camisa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha', 'remember_token',
    ];

    public function getAuthPassword() { //Para sistema poder fazer login via atributo "password"
        return $this->senha;
    }
    
    public function getTable(){
        $schema = isset($this->schema)?$this->schema:env('DB_SCHEMA');
        return $schema.'.'.$this->table;
    }
    
    public function tarefas(){
        return $this->belongsToMany('App\Tarefa');
    }
}
