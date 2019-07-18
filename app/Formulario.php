<?php

namespace App;

use App\Mods\Model;
use App\Projeto;
use App\Pessoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Formulario extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formulario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idformulario', 'tipo', 'edicao_id'
    ];


}
