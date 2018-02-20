@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">

    <div class="page-header">
	    <h1>Olá {{ Auth::user()->nome }}</h1>      
	</div>

	<ul class="nav nav-pills nav-stacked" style="width: 250px">
		<li><a href="{{route('administrador')}}">Administrador</a></li>
		<li><a href="{{route('comissaoAvaliadora')}}">Cadastro Avaliador / Revisor</a></li>
		<li><a href="{{route('avaliador')}}">Avaliador</a></li>
		<li><a href="{{route('revisor')}}">Revisor</a></li>
	</ul>



</div>

@endsection
