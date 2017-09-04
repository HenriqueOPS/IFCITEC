<?php

namespace App;

use App\Mods\Model;

class Endereco extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'endereco';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rua', 'numero', 'bairro', 'cidade', 'estado', 'cep', 'complemento',
    ];
    
     public function pessoa()
    {
        return $this->belongsTo('App\Pessoa');
    }

}