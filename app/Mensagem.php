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

    static public function fetchMessageContent(string $nome, string $tipo)
    {
        $mensagem = Mensagem::where('tipo', '=', $tipo)->where('nome', '=', $nome)->first();

        return $mensagem->conteudo;
    }
}
