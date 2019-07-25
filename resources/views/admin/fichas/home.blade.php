@extends('layouts.app')

@section('content')
<div class="container">

	<div class="row">

		<div class="col-md-12 main main-raised">

			<div class="col-md-12 text-center">
				<h2>Painel administrativo</h2>
				<h3>Fichas</h3>
			</div>

			<ul class="nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
				<li>
					<a href="{{ route('mostraCat') }}">
						<i class="material-icons">list_alt</i>
						Categoria
					</a>
				</li>
				<li>
					<a href="{{ route('listaCat') }}">
						<i class="material-icons">description</i>
						Critérios de Avaliação
					</a>
				</li>

				<li>
					<a href="{{ route('telaEscolheTipo') }}">
						<i class="material-icons">description</i>
						Montar Formulário
					</a>
				</li>
			</ul>

			<a href="{{ route('homologar-projetos') }}" id="homologarTrabalhos" class="btn btn-sm btn-primary">Homologar Trabalhos</a>


			<div class="list-projects">




				<div class="row project">
					<div class="col-md-8">
						Ensino Médio
					</div>
					<div class="col-md-2 actions text-center">
						<span class="label label-info">Homologação</span>
					</div>
					<div class="col-md-2 actions text-center">
						<a class="dados-projeto" href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
					</div>
				</div>



				<div class="row project">
					<div class="col-md-8">
						Fundamental
					</div>
					<div class="col-md-2 actions text-center">
						<span class="label label-success">Avaliação</span>
					</div>
					<div class="col-md-2 actions text-center">
						<a class="dados-projeto" href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
					</div>
				</div>








			</div>








		</div>
	</div>
</div>
@endsection








