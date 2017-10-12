<?php

namespace App;

use App\Mods\Model;

class AreaConhecimento extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area_conhecimento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_conhecimento', 'descricao',
    ];
    
    public function projetos() {
        return $this->hasMany('App\Projeto');
    }
    
    public function niveis(){
        return $this->belongsToMany('App\Nivel','area_nivel','area_id','nivel_id');
    }
}
