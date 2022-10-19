<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

class Mensagem extends Model
{
    protected $table = 'mensagem';

    protected $fillable = [
        'conteudo', 'tipo'
    ];
}
