<?php

namespace App;

use App\Mods\Model;

class PalavraChave extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'palavra_chave';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'palavra', 
    ];
    
    public function projetos() {
        return $this->belongsToMany('App\Projeto');
    }
}
