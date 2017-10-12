<?php

namespace App;

use App\Mods\Model;

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

    public $timestamps = false;

    public function projeto() {
        return $this->belongsTo('App\Projeto');
    }

    public function pessoa() {
        return $this->belongsTo('App\Pessoa');
    }
    
    public function situacao() {
        return $this->belongsTo('App\Situacao');
    }

}
