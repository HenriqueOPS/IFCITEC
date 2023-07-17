<?php

namespace App;

use App\Mods\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Brindes extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brindes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'nome','quantidade','descricao'
    ];


 

}
