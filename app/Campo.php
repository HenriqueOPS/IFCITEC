<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

class Campo extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'campos_avaliacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'edicao_id', 'tipo','campo','categoria_id',
        'val_0','val_25','val_50','val_75','val_100'
    ];

    public function getCamposCategoria() {
        return $this->belongsToMany('Categoria', 'categoria_avaliacao','categoria_id', 'id' );
    }

}