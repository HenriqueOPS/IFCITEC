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
		<div class="col-md-4 col-sm-12">

			<ul class="nav nav-pills nav-stacked">
				<li><a href="{{route('administrador')}}">Administrador</a></li>
				<li><a href="{{route('comissaoAvaliadora')}}">Cadastro Avaliador / Revisor</a></li>
				<li><a href="{{route('avaliador')}}">Avaliador</a></li>
				<li><a href="{{route('revisor')}}">Revisor</a></li>
			</ul>

		</div>

		<div class="col-md-8 col-sm-12 text-center">

			<img src="{{ asset('img/scholarship.svg') }}" width="150">

		</div>
	</div>



</div>

@endsection
