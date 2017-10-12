<?php

namespace App;

use App\Mods\Model;

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
        'tarefa', 'descricao',
    ];
    
    public function pessoas() {
        return $this->belongsToMany('App\Pessoa');
    }
    

}
