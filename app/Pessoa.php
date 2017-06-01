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
    protected $table = 'pessoas';
    
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

    public function getAuthPassword() { //Para sistema poder fazer login vinha atributo "password"
        return $this->senha;
    }

}
