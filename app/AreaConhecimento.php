<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

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

    public function getClassificacaoProjetos($id){
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.area_id','=',$id)
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            ->where('projeto.nota_avaliacao','<>',NULL)
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();
        return $projetos;
    }

    public function getProjetosClassificados($id){
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.titulo', 'projeto.situacao_id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.area_id','=',$id)
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Homologado')->get()->first()->id)
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();
            
        return $projetos;
    }

    public function getProjetosCompareceram(){
        $projetos = 'oi';

        return $projetos;
    }


}
