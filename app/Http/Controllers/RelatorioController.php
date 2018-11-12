<?php

namespace App\Http\Controllers;

use App\AreaConhecimento;
use App\Nivel;
use App\Edicao;
use App\Escola;
use App\Projeto;
use App\Pessoa;
use App\Funcao;
use App\Tarefa;
use App\Situacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RelatorioController extends Controller
{
	public function csv($id, $edicao)
	{
		if ($id == 1) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',$edicao)
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id)
			->get();
			$filename = "Avaliadores.csv";
		} else if ($id == 2) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',$edicao)
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id)
			->get();
			$filename = "Homologadores.csv";
		} else if ($id == 3) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',$edicao)
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Autor')->first()->id)
			->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Orientador')->first()->id)
			->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Coorientador')->first()->id)
			->get();
			$filename = "ParticipantesProjeto.csv";
		} else if ($id == 4) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',$edicao)
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Voluntário')->first()->id)
			->get();
			$filename = "Voluntarios.csv";
		} else if ($id == 5) {
			$resultados = DB::table('projeto')
			->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
			->select('projeto.titulo', 'nivel.nivel', 'area_conhecimento.area_conhecimento')
			->where('projeto.edicao_id',$edicao)
			->get();
			$filename = "Projetos.csv";
		}


		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('Nome','Email'), ';');

		foreach ($resultados as $row) {
			$nome = utf8_decode($row->nome);
			fputcsv($handle, array($nome,$row->email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}


	public function csvAnais($edicao)
	{
		$projetos = Projeto::select( 'projeto.id', 'projeto.titulo', 'escola.nome_completo', 'nivel.nivel', 'area_conhecimento.area_conhecimento', 'projeto.resumo')
						->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
						->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
						->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
						->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
						->where('escola_funcao_pessoa_projeto.edicao_id', $edicao)
						->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            			->where('projeto.nota_avaliacao','<>',NULL)
			            ->orderBy('nivel.nivel')
						->orderBy('area_conhecimento.area_conhecimento')
						->orderBy('projeto.titulo')
						->distinct('projeto.id')
						->get();

		$filename = "RelatorioAnais.csv";

		$handle = fopen($filename, 'w+');

		$handle = fopen($filename, 'w+');

		$nivel = utf8_decode('Nível');
		$area = utf8_decode('Área do Conhecimento');
		
		fputcsv($handle, array('Projeto','Integrantes','Escola',$nivel,$area,'Resumo'), ';');

		foreach ($projetos as $projeto) {
					$integrantes = '';
					$cont = 0;
					foreach ($projeto->getAutores($projeto->id, $edicao) as $autor) {
						if ($cont != 0) {
							$integrantes = $integrantes.', ';
						}
						$integrantes = $integrantes.$autor->nome.' (Autor)';
						$cont++;
					}
					foreach ($projeto->getOrientador($projeto->id, $edicao) as $orientador) {
						$integrantes = $integrantes.', '.$orientador->nome.' (Coordenador)';
					}
					foreach ($projeto->getCoorientadores($projeto->id, $edicao) as $coorientador) {
						$integrantes = $integrantes.', '.$coorientador->nome.' (Coorientador)';
					}

					$titulo = utf8_decode($projeto->titulo);
					$integrantes = utf8_decode($integrantes);
					$nivel = utf8_decode($projeto->nivel);
					$area_conhecimento = utf8_decode($projeto->area_conhecimento);
					$escola = utf8_decode($projeto->nome_completo);
					$resumo = utf8_decode($projeto->resumo);

					fputcsv($handle, array($titulo,$integrantes,$escola,$nivel,$area_conhecimento,$resumo), ';');

		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPremiados($edicao)
	{
		$areas = Edicao::find($edicao)->areas;


		$filename = "ProjetosPremiados.csv";

		$handle = fopen($filename, 'w+');
		$nivel = utf8_decode('Nível');
		$area = utf8_decode('Área do Conhecimento');
		$colocacao = utf8_decode('Colocação');
		$funcao = utf8_decode('Função');
		fputcsv($handle, array('Projeto',$nivel,$area,$colocacao,$funcao,'Integrante','Email'), ';');

		foreach ($areas as $area) {
			$cont = 0;
			foreach($area->getClassificacaoProjetosCertificados($area->id, $edicao) as $projeto){
				if($cont == 0){
					$colocacao = 'TERCEIRO LUGAR';
				}

				if($cont == 1){
					$colocacao = 'SEGUNDO LUGAR';
				}

				if($cont == 2){
					$colocacao = 'PRIMEIRO LUGAR';
				}
				$cont++;
				foreach($projeto->pessoas as $pessoa){
					if($pessoa->temFuncaoProjeto('Autor', $projeto->id, $pessoa->id)){
						$funcao = 'Autor';
					}
					if($pessoa->temFuncaoProjeto('Orientador', $projeto->id, $pessoa->id)){
						$funcao = 'Orientador';
					}
					if($pessoa->temFuncaoProjeto('Coorientador', $projeto->id, $pessoa->id)){
						$funcao = 'Coorientador';
					}

					$titulo = utf8_decode($projeto->titulo);
					$nivel = utf8_decode($area->niveis->nivel);
					$area_conhecimento = utf8_decode($area->area_conhecimento);
					$participante = utf8_decode($pessoa->nome);
					$email = utf8_decode($pessoa->email);
					fputcsv($handle, array($titulo,$nivel,$area_conhecimento,$colocacao,$funcao,$participante,$email), ';');
				}
			}
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvProjetos()
	{
		$subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

	    $resultados = Projeto::select('projeto.id', 'titulo', 'situacao_id',
            'nivel.nivel', 'area_conhecimento.area_conhecimento', DB::raw('('.$subQuery.') as nota'))
	    	->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->orderBy('nivel','asc')
            ->orderBy('area_conhecimento','asc')
            ->orderBy('nota','desc')
            ->get();

		$filename = "ProjetosNotasHomologadores.csv";

		$handle = fopen($filename, 'w+');
		$nivel = utf8_decode('Nível');
		$area = utf8_decode('Área do Conhecimento');
		fputcsv($handle, array('Projeto',$nivel,$area,'Nota Final'), ';');

		foreach ($resultados as $row) {
			$titulo = utf8_decode($row->titulo);
			$nivel = utf8_decode($row->nivel);
			$area = utf8_decode($row->area_conhecimento);
			fputcsv($handle, array($titulo,$nivel,$area,$row->nota), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvAutoresConfirmaramPresenca($edicao)
	{
		$resultados = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.email')
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('projeto.presenca', TRUE)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$filename = "AutoresConfirmaramPresenca.csv";

		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Nome','Email'), ';');

		foreach ($resultados as $row) {
			$nome = utf8_decode($row->nome);
			fputcsv($handle, array($nome,$row->email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvAutoresHomologados()
	{
		$resultados = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.email')
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$filename = "AutoresHomologados.csv";

		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Nome','Email'), ';');

		foreach ($resultados as $row) {
			$nome = utf8_decode($row->nome);
			fputcsv($handle, array($nome,$row->email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}


	public function participantesCompareceram($edicao)
	{
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.id')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('projeto.nota_avaliacao','<>',0)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
						->where('funcao_pessoa.edicao_id', $edicao)
						->distinct('pessoa.id')
						->get();
		

		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome','pessoa.id')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
             			->where('projeto.nota_avaliacao','<>',0)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.id')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
             			->where('projeto.nota_avaliacao','<>',0)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
			$voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('presenca', 'pessoa.id', '=', 'presenca.id_pessoa')
						->select( 'pessoa.nome', 'pessoa.id')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

			return \PDF::loadView('relatorios.participantesCompareceram', array('autores' => $autores, 'coorientadores' => $coorientadores, 'orientadores' => $orientadores, 'voluntarios' => $voluntarios))->download('participantes_compareceram.pdf');
	}

	public function csvPresencaAutores($edicao)
	{
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('projeto.nota_avaliacao','<>',0)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$filename = "RelatorioPresencaAutores.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE', 'PROJETO_PARTICIPANTE'), ';');

		foreach ($autores as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			$titulo = utf8_decode($row->titulo);
			fputcsv($handle, array($nome,$email,$row->cpf,$titulo), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPresencaAvaliadores($edicao)
	{
		$avaliadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('avaliacao', 'pessoa.id', '=', 'avaliacao.pessoa_id')
						->join('projeto', 'avaliacao.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Avaliador')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$filename = "RelatorioPresencaAvaliadores.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE','PROJETO_PARTICIPANTE'), ';');

		foreach ($avaliadores as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			$titulo = utf8_decode($row->titulo);
			fputcsv($handle, array($nome,$email,$row->cpf,$titulo), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPresencaCoorientadores($edicao)
	{
		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email','projeto.titulo')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
             			->where('projeto.nota_avaliacao','<>',0)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$filename = "RelatorioPresencaCoorientadores.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE', 'PROJETO_PARTICIPANTE'), ';');

		foreach ($coorientadores as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			$titulo = utf8_decode($row->titulo);
			fputcsv($handle, array($nome,$email,$row->cpf,$titulo), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPresencaOrientadores($edicao)
	{
		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
             			->where('projeto.nota_avaliacao','<>',0)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$filename = "RelatorioPresencaOrientadores.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE','PROJETO_PARTICIPANTE'), ';');

		foreach ($orientadores as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			$titulo = utf8_decode($row->titulo);
			fputcsv($handle, array($nome,$email,$row->cpf,$titulo), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPresencaVoluntarios($edicao)
	{
		$voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('presenca', 'pessoa.id', '=', 'presenca.id_pessoa')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$filename = "RelatorioPresencaVoluntarios.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE'), ';');

		foreach ($voluntarios as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			fputcsv($handle, array($nome,$email,$row->cpf,$row->rg), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPresencaHomologadores($edicao)
	{
		$homologadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('revisao', 'pessoa.id', '=', 'revisao.pessoa_id')
						->join('projeto', 'revisao.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Homologador')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$filename = "RelatorioPresencaHomologaores.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE','PROJETO_PARTICIPANTE'), ';');

		foreach ($homologadores as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			$titulo = utf8_decode($row->titulo);
			fputcsv($handle, array($nome,$email,$row->cpf,$titulo), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvPresencaComissaoOrganizadora()
	{
		$comissao = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where(function ($q){
                                        $q->where('funcao_pessoa.funcao_id', Funcao::select(['id'])
                                            ->where('funcao', 'Administrador')
                                            ->first()->id);
                                        $q->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])
                                            ->where('funcao', 'Organizador')
                                            ->first()->id);
                        })
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$filename = "RelatorioPresencaComissao.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('NOME_PARTICIPANTE','EMAIL_PARTICIPANTE','CPF_PARTICIPANTE'), ';');

		foreach ($comissao as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			fputcsv($handle, array($nome,$email,$row->cpf), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function notaProjetosArea(){
		$subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

	    $projetos = Projeto::select('projeto.id', 'titulo', 'situacao_id',
            'nivel.nivel', 'area_conhecimento.area_conhecimento', DB::raw('('.$subQuery.') as nota'))
	    	->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->orderBy('nivel','asc')
            ->orderBy('area_conhecimento','asc')
            ->orderBy('nota','desc')
            ->get();

        return \PDF::loadView('relatorios.notaProjetosArea', array('projetos' => $projetos))->setPaper('A4', 'landscape')->download('nota_projetos_cadastrados.pdf');

	}

	public function notaProjetosNivel(){

		$niveis = Edicao::find(Edicao::getEdicaoId())->niveis;

		return \PDF::loadView('relatorios.notaProjetosNivel', array('niveis' => $niveis))->setPaper('A4', 'landscape')->download('nota_projetos_cadastrados.pdf');

	}

	public function projetosClassificados($edicao){

        $areas = Edicao::find($edicao)->areas;

        return \PDF::loadView('relatorios.projetosClassificados', array('areas' => $areas, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('projetos_classificados_area.pdf');
	}

	public function projetosClassificadosNivel($edicao){

		$niveis = Edicao::find($edicao)->niveis;

		return \PDF::loadView('relatorios.projetosClassificadosNivel', array('niveis' => $niveis, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('projetos_classificados_nivel.pdf');
	}

	public function projetosNaoHomologadosNivel($edicao){

		$niveis = Edicao::find($edicao)->niveis;

		return \PDF::loadView('relatorios.projetosNaoHomologadosNivel', array('niveis' => $niveis, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('projetos_nao_homologados_nivel.pdf');
	}

	public function projetosClassificadosSemNota($edicao){

		$projetos = Projeto::select('projeto.titulo', 'projeto.situacao_id')
			->where('projeto.edicao_id','=',$edicao)
			->where('projeto.situacao_id','=', Situacao::where('situacao', 'Homologado')->get()->first()->id)
			->orderBy('projeto.titulo', 'asc')
			->get();

		return \PDF::loadView('relatorios.projetosClassificadosSemNota', array('projetos' => $projetos))->download('projetos_classificados.pdf');
	}


	public function niveis($edicao){
		$niveis = Edicao::find($edicao)->niveis;

		return \PDF::loadView('relatorios.niveis', array('niveis' => $niveis))->setPaper('A4', 'landscape')->download('niveis.pdf');
	}

	public function escolas(){
		$escolas = DB::table('escola')->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
						->select('*')
						->orderBy('escola.nome_curto')
						->get();

		return \PDF::loadView('relatorios.escolas', array('escolas' => $escolas))->download('escolas.pdf');
	}

	public function autores($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.autores', array('autores' => $autores, 'cont' => $cont))->download('autores.pdf');
	}

	public function orientadores($edicao){
		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.orientadores', array('orientadores' => $orientadores, 'cont' => $cont))->download('orientadores.pdf');
	}

	public function coorientadores($edicao){
		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$cont = 0;

		return \PDF::loadView('relatorios.coorientadores', array('coorientadores' => $coorientadores, 'cont' => $cont))->download('coorientadores.pdf');
	}

	public function voluntarios($edicao){
		$voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		$cont = 0;

		return \PDF::loadView('relatorios.voluntarios', array('voluntarios' => $voluntarios, 'cont' => $cont))->download('voluntarios.pdf');
	}

	public function homologadores($edicao){
		$homologadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Homologador')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();


		$cont = 0;

		return \PDF::loadView('relatorios.homologadores', array('homologadores' => $homologadores, 'cont' => $cont))->download('homologadores.pdf');
	}

	public function avaliadores($edicao){
		$avaliadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Avaliador')->first()->id)
						->where('funcao_pessoa.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.avaliadores', array('avaliadores' => $avaliadores, 'cont' => $cont))->download('avaliadores.pdf');
	}

	public function projetosAvaliador($edicao){
		$avaliadores = Pessoa::select('pessoa.nome', 'pessoa.id')
			->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
			->where('funcao_id', Funcao::where('funcao', 'Avaliador')->first()->id)
			->where('funcao_pessoa.edicao_id', $edicao)
			->orderBy('pessoa.nome')
			->get();

		return \PDF::loadView('relatorios.projetosAvaliador', array('avaliadores' => $avaliadores, 'edicao' => $edicao))->download('projetos_avaliador.pdf');
	}

	public function autoresLanche($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
			 ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             })
			->where('funcao_pessoa.edicao_id', $edicao)
			->where('projeto.presenca', TRUE)
			->where('escola.nome_curto', '!=' , 'IFRS Canoas')
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();

		$cont = 0;

		return \PDF::loadView('relatorios.autoresLanche', array('autores' => $autores, 'cont' => $cont))->download('autores_lanche.pdf');
	}

	public function autoresPosHomologacao($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
						 ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.autoresPosHomologacao', array('autores' => $autores, 'cont' => $cont))->download('autores_pos_homologacao.pdf');
	}

	public function camisaTamanho($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.camisa')
						 ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		return \PDF::loadView('relatorios.camisaTamanho', array('autores' => $autores))->download('autores_tamanho_camisa.pdf');
	}

	public function camisaTamanhoAssinatura($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.camisa')
						 ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		return \PDF::loadView('relatorios.camisaTamanhoAssinatura', array('autores' => $autores))->setPaper('A4', 'landscape')->download('autores_tamanho_camisa_assinatura.pdf');
	}

	public function participantesAssinatura($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.id')
                        ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.id')
                        ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
                        ->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.id')
                        ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
                        ->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();


		return \PDF::loadView('relatorios.participantesAssinatura', array('autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores))->setPaper('A4', 'landscape')->download('participantes_assinatura.pdf');
	}

	public function orientadoresPosHomologacao($edicao){
		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.orientadoresPosHomologacao', array('orientadores' => $orientadores,'cont' => $cont))->download('orientadores_pos_homologacao.pdf');
	}

	public function coorientadoresPosHomologacao($edicao){
		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.coorientadoresPosHomologacao', array('coorientadores' => $coorientadores,'cont' => $cont))->download('coorientadores_pos_homologacao.pdf');
	}

	public function projetos($edicao){
		$projetos = DB::table('projeto')->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
			->select('projeto.titulo', 'projeto.id', 'escola_funcao_pessoa_projeto.escola_id')
			->orderBy('titulo')
			->where('projeto.edicao_id', $edicao)
			->get()
			->keyBy('id')
			->toArray();

		$autores = array();
		$orientadores = array();
		$coorientadores = array();

		//Participantes dos projetos
		if ($projetos) {
			$idAutor = Funcao::where('funcao', 'Autor')->first();
			$idOrientador = Funcao::where('funcao', 'Orientador')->first();
			$idCoorientador = Funcao::where('funcao', 'Coorientador')->first();

			$ids = array_keys($projetos);

			$autores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
				->whereIn('projeto_id', $ids)
				->where('funcao_id', $idAutor->id)
				->get()
				->toArray();

			$orientadores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
				->whereIn('projeto_id', $ids)
				->where('funcao_id', $idOrientador->id)
				->get()
				->toArray();

			$coorientadores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
				->whereIn('projeto_id', $ids)->where('funcao_id', $idCoorientador->id)
				->get()
				->toArray();
		}

		return \PDF::loadView('relatorios.projetos', array('projetos' => $projetos,'autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores))->download('projetos.pdf');
	}

	public function areas($edicao){
		$areas = Edicao::find($edicao)->areas;

		return \PDF::loadView('relatorios.areas', array('areas' => $areas))->setPaper('A4', 'landscape')->download('areas.pdf');
	}

	public function edicoes(){
		$edicoes = Edicao::orderBy('ano')->get();

		return \PDF::loadView('relatorios.edicoes', array('edicoes' => $edicoes))->download('edicoes.pdf');
	}

	public function funcoesUsuarios(){
		$usuarios = Pessoa::select('pessoa.id', 'pessoa.nome', 'pessoa.email')
				->get();

		return \PDF::loadView('relatorios.funcoesUsuarios', array('usuarios' => $usuarios))->download('funcoes.pdf');
	}

	public function escolaProjetos($id){
		$escola = Escola::find($id);

		$projetos = DB::table('escola_funcao_pessoa_projeto')
				->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
				->select('escola_funcao_pessoa_projeto.escola_id', 'projeto.id', 'projeto.titulo')
			->where('escola_id', $id)
			->where('escola_funcao_pessoa_projeto.edicao_id',Edicao::getEdicaoId())
			->distinct('projeto.id')
			->get()
			->toArray();
		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.escolaProjetos', array('escola' => $escola, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('escola_projetos.pdf');
	}

	public function nivelProjetos($id){
		$nivel = Nivel::find($id);

		$projetos = Projeto::where('nivel_id', $id)->where('edicao_id', Edicao::getEdicaoId())->get();

		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.nivelProjetos', array('nivel' => $nivel, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('nivelProjetos.pdf');
	}

	public function areaProjetos($id){
		$area = AreaConhecimento::find($id);

		$projetos = Projeto::where('area_id', $id)->where('edicao_id', Edicao::getEdicaoId())->get();

		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.areaProjetos', array('area' => $area, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('areaProjetos.pdf');
	}

	public function voluntarioTarefa($edicao){

		$voluntarios = Pessoa::select('pessoa.id', 'pessoa.nome', 'pessoa.email', 'tarefa.tarefa')
            ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('funcao', 'funcao_pessoa.funcao_id', '=', 'funcao.id')
            ->join('pessoa_tarefa', 'pessoa.id', '=', 'pessoa_tarefa.pessoa_id')
            ->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
            ->where('funcao.funcao','Voluntário')
            ->where('funcao_pessoa.edicao_id',$edicao)
            ->where('pessoa_tarefa.edicao_id',$edicao)
            ->orderBy('pessoa.nome')
            ->get();

		return \PDF::loadView('relatorios.voluntarioTarefa', array('voluntarios' => $voluntarios))->download('voluntarios_tarefas.pdf');
	}

	public function tarefaVoluntarios($id){
		$tarefa = Tarefa::find($id);

		return \PDF::loadView('relatorios.tarefaVoluntarios', array('tarefa' => $tarefa))->download('tarefaVoluntarios.pdf');
	}

	public function homologadoresArea($edicao){
		$areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
				->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
				->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
				->where('area_edicao.edicao_id',$edicao)
				->orderBy('nivel.nivel')
				->get()
				->toArray();

		$homologadores = DB::table('pessoa')->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
				->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
				->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
				->select('pessoa.nome', 'areas_comissao.area_id')
				->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id)
				->where('funcao_pessoa.edicao_id',$edicao)
				->orderBy('pessoa.nome')
				->get()
				->toArray();
		$cont = 0;
		return \PDF::loadView('relatorios.homologadoresArea', array('areas' => $areas,'homologadores' => $homologadores, 'cont' => $cont))->download('homologadores_area.pdf');
	}

	public function avaliadoresArea($edicao){
		$areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
				->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
				->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
				->where('area_edicao.edicao_id',$edicao)
				->orderBy('nivel.nivel')
				->get()
				->toArray();

		$avaliadores = DB::table('pessoa')->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
				->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
				->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
				->select('pessoa.nome', 'areas_comissao.area_id')
				->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id)
				->where('funcao_pessoa.edicao_id',$edicao)
				->orderBy('pessoa.nome')
				->get()
				->toArray();

		$cont = 0;
		return \PDF::loadView('relatorios.avaliadoresArea', array('areas' => $areas,'avaliadores' => $avaliadores, 'cont' => $cont))->download('avaliadores_area.pdf');
	}

	public function homologadoresProjeto($edicao){
		$projetos = Projeto::select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',$edicao)
				->orderBy('projeto.titulo')
				->get();

		return \PDF::loadView('relatorios.homologadoresProjeto', array('projetos' => $projetos))->download('homologadores_projeto.pdf');
	}


	public function avaliadoresProjeto($edicao){
		$projetos = Projeto::select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',$edicao)
				->orderBy('projeto.titulo')
				->get();

		return \PDF::loadView('relatorios.avaliadoresProjeto', array('projetos' => $projetos))->download('avaliadores_projeto.pdf');
	}

	public function projetosConfirmaramPresenca($edicao){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',$edicao)
				->where('projeto.presenca', TRUE)
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.projetosConfirmaramPresenca', array('projetos' => $projetos))->download('projetos_comparecerão.pdf');
	}

	public function classificacaoProjetos($edicao){
		$areas = Edicao::find($edicao)->areas;

        return \PDF::loadView('relatorios.classificacaoProjetos', array('areas' => $areas, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('classificacao_projetos.pdf');
	}

	public function premiacaoProjetos($edicao){
		$areas = Edicao::find($edicao)->areas;

        return \PDF::loadView('relatorios.premiacaoProjetos', array('areas' => $areas, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('premiacao_projetos.pdf');
	}

	public function classificacaoGeral($edicao){
		$niveis = Edicao::find($edicao)->niveis;

        return \PDF::loadView('relatorios.classificacaoGeral', array('niveis' => $niveis, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('classificacao_geral.pdf');
	}

	public function statusProjetos($edicao){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo', 'situacao.situacao')
				->join('situacao', 'projeto.situacao_id', '=', 'situacao.id')
				->where('projeto.edicao_id',$edicao)
				->orderBy('situacao.situacao')
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.statusProjetos', array('projetos' => $projetos))->download('status_projetos.pdf');
	}

	public function projetosCompareceram($edicao){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->join('presenca', 'pessoa.id', '=', 'presenca.id_pessoa')
				->where('projeto.edicao_id',$edicao)
				->orderBy('projeto.titulo')
				->distinct('projeto.id')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.projetosCompareceram', array('projetos' => $projetos))->download('projetos_compareceram.pdf');
	}

	public function projetosCompareceramPorAutor($edicao){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('escola_funcao_pessoa_projeto.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
             			})
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.edicao_id', $edicao)
						->orderBy('pessoa.nome')
						->get();

		return \PDF::loadView('relatorios.projetosCompareceramPorAutor', array('autores' => $autores))->download('projetos_compareceram_autor.pdf');
	}

	public function projetosCompareceramIFRSCanoas($edicao){

        $areas = Edicao::find($edicao)->areas;

        return \PDF::loadView('relatorios.projetosCompareceramIFRSCanoas', array('areas' => $areas, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('projetos_compareceram_ifrs_canoas.pdf');
	}

	public function gerarLocalizacaoProjetos($edicao){
		$niveis = DB::table('nivel_edicao')
			->select(['nivel.id','nivel','min_ch','max_ch','palavras'])
			->where('edicao_id', '=',$edicao)
			->join('nivel','nivel_edicao.nivel_id','=','nivel.id')
			->get();

		return view('admin.gerarLocalizacaoProjetos', array('edicao' => $edicao))->withNiveis($niveis);
	}

	public function geraLocalizacaoProjetos(Request $req, $edicao){
		$data = $req->all();
		$num = $data['button'];
		$ids = array();
		$cont = 0;

		foreach ($data['bloco'] as $key => $bloco) {
			$numeroSalas = ($data['ate'][$key] - $data['de'][$key]) + 1;
			$numeroProjetos = $data['num'][$key];

			for ($i = $data['de'][$key]; $i <= $data['ate'][$key]; $i++) {

                $projetos[$bloco][$i] = DB::table('projeto')
                    ->select('projeto.id', 'projeto.titulo', 'area_conhecimento.area_conhecimento', 'nivel.nivel', 'escola.nome_curto')
                    ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
                    ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
                    ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
                    ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
                    ->where('projeto.edicao_id',$edicao)
                    ->where(function ($q){
                        $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                        $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
                    })
                    ->where('projeto.presenca', TRUE)
                    ->where('nivel.id', $data['nivel'][$key])
                    ->whereNotIn('projeto.id', $ids)
                    ->distinct('projeto.id')
                    ->orderBy('area_conhecimento.area_conhecimento')
                    ->orderBy('nivel.nivel')
                    ->orderBy('projeto.titulo')
                    ->limit($numeroProjetos)
                    ->get()
                    ->toArray();

                $ids = array_merge($ids, array_column($projetos[$bloco][$i], 'id'));

			}
		}

		$cont = 1;
		if($num == 1){
			return \PDF::loadView('relatorios.geraLocalizacaoProjetos',array('projetos' => $projetos, 'cont' => $cont))->setPaper('A4', 'landscape')->download('projetos_identificacao.pdf');
		}
		if ($num == 2) {
			return \PDF::loadView('relatorios.identificacaoProjetos',array('projetos' => $projetos, 'cont' => $cont))->setPaper('A4', 'landscape')->download('projetos_localizacao.pdf');
		}
	}

	public function gerarValeLanche($edicao){
		return view('admin.gerarValeLanche', array('edicao' => $edicao));
	}

	public function valeLanche(Request $req, $edicao){
		$data = $req->all();
		$dias = $data['dias'];

		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
			->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
             })
			->where('funcao_pessoa.edicao_id', $edicao)
			->where('projeto.presenca', TRUE)
			->where('escola.nome_curto', '!=' , 'IFRS Canoas')
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();

		$cont = $autores->count() * $dias;

		return view('relatorios.valeLanche', array('cont' => $cont));
	}

	public function projetosConfirmaramPresencaArea($edicao){
		$areas = Edicao::find($edicao)->areas;


		return \PDF::loadView('relatorios.projetosConfirmaramPresencaArea', array('areas' => $areas, 'edicao' => $edicao))->download('projetos_presenca_nivel.pdf');
	}

	public function premiacaoCertificados($edicao){
		$areas = Edicao::find($edicao)->areas;

		$subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id', 'escola.nome_curto', 'projeto.id', 'area_conhecimento.area_conhecimento')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id','=',$edicao)
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            ->where('projeto.nota_avaliacao','<>',NULL)
            ->groupBy('projeto.id')
            ->groupBy('area_conhecimento.area_conhecimento')
            ->groupBy('escola.nome_curto')
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();

        $data = Edicao::select('feira_fechamento')
        	->where('id',$edicao)->get();
        $data = date('d/m/Y', strtotime($data->first()->feira_fechamento));

		return \PDF::loadView('relatorios.premiacaoCertificados', array('areas' => $areas, 'projetos' => $projetos, 'data' => $data, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('premiacao_certificados.pdf');
	}


}
