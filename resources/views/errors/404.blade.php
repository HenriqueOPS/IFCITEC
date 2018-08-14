@extends('layouts.app')

@section('css')
	<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="container">



		<div class="page-header">
			<h1>Erro inesperado</h1>



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


	</div>

@endsection
