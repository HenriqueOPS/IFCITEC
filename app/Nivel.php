<?php

namespace App;

use App\Mods\Model;

class Nivel extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nivel';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nivel', 'descricao',
    ];
    
    public function projetos() {
        return $this->hasMany('App\Projeto');
    }
    
    public function areas_conhecimento(){
        return $this->belongsToMany('App\AreaConhecimento','area_nivel','nivel_id','area_id');
    }
}
