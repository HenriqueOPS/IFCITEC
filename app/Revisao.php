<?php

namespace App;

use App\Model;

class Revisao extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'revisao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'observacao', 
    ];
}
