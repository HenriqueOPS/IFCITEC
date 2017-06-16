<?php

namespace App;

use App\Model;

class Funcao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'funcao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'funcao', 'descricao',
    ];
}
