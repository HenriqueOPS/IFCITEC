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


		<ul class="col-md-3 nav nav-pills nav-stacked">
			<li><a href="{{route('administrador')}}">Administrador</a></li>
			<li><a href="{{route('comissaoAvaliadora')}}">Cadastro Avaliador / Revisor</a></li>
			<li><a href="{{route('avaliador')}}">Avaliador</a></li>
			<li><a href="{{route('revisor')}}">Revisor</a></li>
		</ul>

		<div class="col-md-9">

			<h3>Debug =)</h3>

			<ul class="nav nav-pills nav-stacked">
				<li>Edição ID: {{ \App\Edicao::getEdicaoId()  }}</li>

				<li>Organizador: {{Auth::user()->temFuncao('Organizador')}}</li>
				<li>Orientador: {{Auth::user()->temFuncao('Orientador')}}</li>
				<li>Avaliador: {{Auth::user()->temFuncao('Avaliador')}}</li>
				<li>Revisor: {{Auth::user()->temFuncao('Revisor')}}</li>
				<li>Administrador: {{Auth::user()->temFuncao('Organizador')}}</li>

			</ul>

		</div>

	</div>


</div>

@endsection
