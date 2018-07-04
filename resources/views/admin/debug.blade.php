@extends('layouts.app')

@section('css')
	<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container">

		<div class="page-header">
			<h1>Olá {{ Auth::user()->nome }}</h1>

		</div>

		<div class="row">

			<div class="col-md-12 main main-raised">

				<h3>Debug =)</h3>

				<pre>{{Auth::user()}}</pre>

				<ul class="nav nav-pills nav-stacked">
					<li>Edição ID: {{ \App\Edicao::getEdicaoId() }}</li>
					<li>Edição Ano: {{ \App\Edicao::getAnoEdicao()  }}</li>

					<li>Organizador: {{Auth::user()->temFuncao('Organizador')}}</li>
					<li>Orientador: {{Auth::user()->temFuncao('Orientador')}}</li>
					<li>Avaliador: {{Auth::user()->temFuncao('Avaliador')}}</li>
					<li>Homologador: {{Auth::user()->temFuncao('Homologador')}}</li>
					<li>Administrador: {{Auth::user()->temFuncao('Administrador')}}</li>

					<li>Consulta Periodo Inscrição: {{ \App\Edicao::consultaPeriodo('Inscrição')  }}</li>
					<li>Consulta Periodo Homologação: {{ \App\Edicao::consultaPeriodo('Homologação')  }}</li>
					<li>Consulta Periodo Avaliação: {{ \App\Edicao::consultaPeriodo('Avaliação')  }}</li>
					<li>Consulta Periodo Credenciamento: {{ \App\Edicao::consultaPeriodo('Credenciamento') }}</li>
					<li>Consulta Periodo Voluntário: {{ \App\Edicao::consultaPeriodo('Voluntário') }}</li>
					<li>Consulta Periodo Comissão: {{ \App\Edicao::consultaPeriodo('Comissão') }}</li>

				</ul>

			</div>

		</div>


	</div>

@endsection
