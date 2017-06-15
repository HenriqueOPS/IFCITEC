<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SchemaObservable as SchemaObservable;

class PalavraChave extends Model {

    use SchemaObservable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'palavra_chave';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'palavra', 
    ];
}
