<?php

namespace App;

use App\Mods\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Edicao extends Model
{

    protected $table = 'edicao';

    protected $fillable = [
        'inscricao_abertura','inscricao_fechamento',
        'homologacao_abertura','homologacao_fechamento',
        'avaliacao_abertura','avaliacao_fechamento',
        'credenciamento_abertura','credenciamento_fechamento',
        'voluntario_abertura','voluntario_fechamento',
        'comissao_abertura','comissao_fechamento',
        'relatorio_abertura','relatorio_fechamento',
		'feira_abertura', 'feira_fechamento', 'ano', 'projetos'];

    public function edicoes() {
        return $this->belongsToMany('App\Edicao', 'edicao');
    }

    public function niveis() {
        return $this->belongsToMany('App\Nivel', 'nivel_edicao','nivel_id','edicao_id');
    }

    public function areas() {
        return $this->belongsToMany('App\AreaConhecimento', 'area_edicao','area_id','edicao_id');
    }

}
