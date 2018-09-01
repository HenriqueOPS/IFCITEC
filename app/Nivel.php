<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

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
        'nivel', 'descricao', 'max_ch', 'min_ch', 'palavras',
    ];

    public function projetos() {
        return $this->hasMany('App\Projeto');
    }

    public function areas_conhecimento(){
        return $this->hasMany('App\AreaConhecimento', 'nivel_id');
    }

    public function edicoes(){
        return $this->belongsToMany('App\Edicao','nivel_edicao','nivel_id','edicao_id');
    }

	public function getProjetosClassificados($id){
		$subQuery = DB::table('revisao')
			->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
			->where('revisao.projeto_id','=',DB::raw('projeto.id'))
			->toSql();

		$projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.titulo', 'projeto.situacao_id')
			->where('projeto.edicao_id','=',Edicao::getEdicaoId())
			->where('projeto.nivel_id','=',$id)
			->where('projeto.situacao_id','=', Situacao::where('situacao', 'Homologado')->get()->first()->id)
			->orderBy('nota', 'desc')
			->orderBy('projeto.created_at', 'asc')
			->get();

		return $projetos;
	}
}
