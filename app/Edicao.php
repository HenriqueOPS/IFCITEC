<?php

namespace App;

use App\Mods\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Edicao extends Model
{

    protected $table = 'edicao';

    protected $fillable = [
        'periodo_inscricao', 'periodo_homologacao',
        'periodo_avaliacao', 'periodo_credenciamento',
        'periodo_voluntario'
    ];

    public function edicoes() {
        return $this->belongsToMany('App\Edicao', 'edicao');
    }



}
