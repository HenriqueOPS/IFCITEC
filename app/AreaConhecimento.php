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
        'area_conhecimento', 'descricao', 'nivel_id'
    ];

    public function projetos() {
        return $this->hasMany('App\Projeto', 'area_id');
    }


    public function niveis(){
        return $this->belongsTo('App\Nivel','nivel_id');
    }

    public function edicoes(){
        return $this->belongsToMany('App\Edicao','area_edicao','area_id','edicao_id');
    }
}
