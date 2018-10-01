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

        $projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id', 'escola.nome_curto', 'projeto.id')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.area_id','=',$id)
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            ->where('projeto.nota_avaliacao','<>',NULL)
            ->groupBy('projeto.id')
            ->groupBy('escola.nome_curto')
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();
        return $projetos;
    }

    public function getClassificacaoProjetosIFRSCanoas($id){
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id', 'escola.nome_curto', 'projeto.id')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.area_id','=',$id)
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            ->where('escola.id','=', Escola::where('nome_curto', 'IFRS Canoas')->get()->first()->id)
            ->where('projeto.nota_avaliacao','<>',NULL)
            ->groupBy('projeto.id')
            ->groupBy('escola.nome_curto')
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();

        return $projetos;
    }

    public function getClassificacaoProjetosCertificados($id){
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id', 'escola.nome_curto', 'projeto.id')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.area_id','=',$id)
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            ->where('projeto.nota_avaliacao','<>',NULL)
            ->groupBy('projeto.id')
            ->groupBy('escola.nome_curto')
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->limit(3)
            ->get();

        return $projetos->reverse();
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

    public function getProjetos($id){
        $projetos = Projeto::select('projeto.id', 'projeto.titulo', 'escola.nome_curto')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.area_id','=',$id)
            ->where('projeto.presenca','=',TRUE)
            ->orderBy('titulo','asc')
            ->distinct('projeto.id')
            ->get();

        return $projetos;
    }


}
