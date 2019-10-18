<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'presenca';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_pessoa',
		'edicao_id',
    ];

    public function pessoas() {
        return $this->hasMany('App\Pessoa', 'id_pessoa');
    }

}
