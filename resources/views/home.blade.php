@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">

	@if(!(\App\Edicao::getEdicaoId()))

		<div class="page-header">
			<h1>Olá {{ Auth::user()->nome }}</h1>

			<div class="alert alert-warning" style="background: #bd8c0e">
				<strong>Ainda não abriram as inscrições!</strong> acompanhe a gente por nosso <a href="http://ifcitec.canoas.ifrs.edu.br">site</a> e por nossa <a href="https://www.facebook.com/IFCITEC/">página no facebook</a> para quaisquer novidades.
			</div>
		</div>

	@else

		<div class="page-header">
			<h1>Olá {{ Auth::user()->nome }}</h1>

			@if((\App\Edicao::consultaPeriodo('Inscrição')))
			<div class="alert alert-info">
				<strong>Estão abertas as Inscrições!</strong> aproveite e inscreva-se agora para a {{ \App\Edicao::getAnoEdicao() }} IFCITEC
			</div>
			@endif

		</div>

		<div class="row">
			<div class="col-md-12 main main-raised" style="padding-top: 20px;">

				<img src="{{ asset('img/scholarship.svg') }}" width="140" style="display: block; margin: 20px auto;">
				<h2 style="text-align: center; border: 0 !important;">Seja bem vindo<span style="font-size: 0.6em; font-weight: bold">(a)</span> a <b>{{ \App\Edicao::getAnoEdicao() }} IFCITEC</b></h2>

				<div class="col-md-10 col-md-offset-1 text-center">
					<a href="{{route('autor')}}" class="confirma btn btn-success">
						<i class="material-icons">bookmarks</i> Ir para Projetos
					</a>
				</div>

			</div>

		</div>

	@endif

</div>

@endsection
