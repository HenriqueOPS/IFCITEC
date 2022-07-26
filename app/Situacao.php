<?php

namespace App;

use App\Mods\Model;

class Situacao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'situacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'situacao', 'descricao',
    ];

    public function revisoes(){
        return $this->hasMany('App\Revisao');
    }

	public function getNumProjetos($id){
		$projetos = Projeto::select('projeto.titulo')
			->where('projeto.edicao_id','=',Edicao::getEdicaoId())
			->where('projeto.situacao_id','=',$id)
			->get();

		return $projetos->count();
	}
}
