<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PeriodosController extends Controller
{
    //implementar esse controller com o registry do laravel

	public function periodoInscricao() {

		$id = DB::select("SELECT id FROM edicao WHERE
							((NOW() AT TIME ZONE 'America/Sao_Paulo') >= inscricao_abertura) AND
							((NOW() AT TIME ZONE 'America/Sao_Paulo') <= inscricao_fechamento)
						  LIMIT 1");

		if($id)
			return $id[0]->id;

		return 0;
	}

	public function periodoHomologacao() {

		$id = DB::select("SELECT id FROM edicao WHERE
							((NOW() AT TIME ZONE 'America/Sao_Paulo') >= homologacao_abertura) AND
							((NOW() AT TIME ZONE 'America/Sao_Paulo') <= homologacao_fechamento)
						  LIMIT 1");

		if($id)
			return $id[0]->id;

		return 0;
	}

	public function periodoAvaliacao() {

		$id = DB::select("SELECT id FROM edicao WHERE
							((NOW() AT TIME ZONE 'America/Sao_Paulo') >= avaliacao_abertura) AND
							((NOW() AT TIME ZONE 'America/Sao_Paulo') <= avaliacao_fechamento)
						  LIMIT 1");

		if($id)
			return $id[0]->id;

		return 0;
	}

	public function periodoCredenciamento() {

		$id = DB::select("SELECT id FROM edicao WHERE
							((NOW() AT TIME ZONE 'America/Sao_Paulo') >= credenciamento_abertura) AND
							((NOW() AT TIME ZONE 'America/Sao_Paulo') <= credenciamento_fechamento)
						  LIMIT 1");

		if($id)
			return $id[0]->id;

		return 0;
	}

	public function periodoVoluntario() {

		$id = DB::select("SELECT id FROM edicao WHERE
							((NOW() AT TIME ZONE 'America/Sao_Paulo') >= voluntario_abertura) AND
							((NOW() AT TIME ZONE 'America/Sao_Paulo') <= voluntario_fechamento)
						  LIMIT 1");

		if($id)
			return $id[0]->id;

		return 0;
	}

	public function periodoComissao() {

		$id = DB::select("SELECT id FROM edicao WHERE
							((NOW() AT TIME ZONE 'America/Sao_Paulo') >= comissao_abertura) AND
							((NOW() AT TIME ZONE 'America/Sao_Paulo') <= comissao_fechamento)
						  LIMIT 1");

		if($id)
			return $id[0]->id;

		return 0;
	}

}
