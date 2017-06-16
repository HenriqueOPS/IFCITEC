<?php

namespace App;

use App\Model;

class AreaConhecimento extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area_conhecimento';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'areaConhecimento', 'descricao',
    ];
}
