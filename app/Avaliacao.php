<?php

namespace App;

use App\Mods\Model;

class Avaliacao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'avaliacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notaFinal', 'observacao', 
    ];
    
    public function projeto(){
        return $this->belongsTo('App\Projeto');
    }
    
    public function pessoa(){
        return $this->belongsTo('App\Pessoa');
    }
}
