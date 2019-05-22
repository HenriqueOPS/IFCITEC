<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

class Categoria extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categoria_avaliacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categoria_avaliacao', 'peso', 'edicao_id', 'nivel_id'
    ];

}