<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\DB;

class Media extends Model
{
    protected $table = 'media';
    public $timestamps = false;
    protected $fillable = [
        'conteudo', 'nome'
    ];

 
}
