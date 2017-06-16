<?php

namespace App;

use App\Model;

class Escola extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'escola';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomeCompleto', 'nomeCurto', 'email', 'moodleLink', 'moodleVersao'
    ];
}
