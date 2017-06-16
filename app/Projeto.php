<?php

namespace App;

use App\Model;

class Projeto extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projeto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo', 'resumo', 'relatorio' 
    ];
}
