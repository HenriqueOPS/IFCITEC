<?php

namespace App;

use App\Mods\Model;
use App\Projeto;
use App\Pessoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Empresa extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'nome_completo', 'nome_fantasia', 'email', 'telefone', 'endereco_id',
        'endereco', 'municipio', 'cep', 'uf', 'bairro', 'numero', 
    ];


 

}
