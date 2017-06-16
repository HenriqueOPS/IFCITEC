<?php

namespace App;

use App\Model;

class Nivel extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nivel';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nivel', 'descricao',
    ];
}
