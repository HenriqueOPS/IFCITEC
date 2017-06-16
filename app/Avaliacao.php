<?php

namespace App;

use App\Model;

class Avaliacao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'avaliacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notaFinal', 'observacao', 
    ];
}
