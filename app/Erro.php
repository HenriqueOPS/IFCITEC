<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Erro extends Model
{
    protected $table = 'erros';

	protected $fillable = [
        'descricao_erro', 'fingerprint'
    ];

	public function getDescricaoErroById($id)
	{
		return DB::table('erros')->where('id', $id)->value('descricao_erro');
	}

	public function getFingerprint()
	{
		return $this->fingerprint;
	}

	public function incrementarDescricaoErro($de)
	{
		$this->descricao_erro .= $de;
	}

	public function getId()
	{
		return $this->id;
	}
}
