<?php

namespace App;

use App\Mods\Model;

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
        return $this->belongsToMany('App\Pessoa');
    }

    public function avaliacoes() {
        return $this->hasMany('App\Avaliacao');
    }

    public function revisoes() {
        return $this->hasMany('App\Revisao');
    }

    public function areaConhecimento() {
        return $this->belongsTo('App\AreaConhecimento');
    }
    
    public function nivel() {
        return $this->belongsTo('App\Nivel');
    }
    
    public function palavrasChaves() {
        return $this->belongsToMany('App\PalavraChave');
    }

}
