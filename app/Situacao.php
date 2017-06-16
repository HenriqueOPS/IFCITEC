<?php

namespace App;

use App\Model;

class Situacao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'situacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'situacao', 'descricao',
    ];
}
