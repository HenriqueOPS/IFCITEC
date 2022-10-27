@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2>Painel administrativo</h2>
			</div>

			@include('partials.admin.navbar')
		</div>
	</div>
	<br><br>
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-xs-12 main main-raised">
				<div class="list-projects">

				<div class="col-md-12" style="margin-bottom: 20px;">
					<a href="{{ route('adminstrador.cadastrarFicha') }}" class="btn btn-primary btn-round">
						<i class="material-icons">add</i> Adicionar Ficha
					</a>
				</div>

			@foreach($formularios as $formulario)

				<div class="row project">
					<div class="col-md-8">
						{{ $formulario->nivel }}
					</div>
					<div class="col-md-2 actions text-center">
						@if ($formulario->tipo == 'homologacao')
							<span class="label label-info">Homologação</span>
						@endif

						@if ($formulario->tipo == 'avaliacao')
							<span class="label label-success">Avaliação</span>
						@endif

					</div>
					<div class="col-md-2 actions text-center">
						<a href="{{ route('administrador.showFicha', $formulario->idformulario) }}">
							<i class="material-icons blue-icon">remove_red_eye</i>
						</a>

						<a href="{{ route('administrador.edit', $formulario->idformulario) }}">
							<i class="material-icons blue-icon">edit</i>
						</a>
					</div>
				</div>

			@endforeach

			</div>

		</div>
	</div>
</div>
@endsection

@section('js')
<script>
	document.getElementById('nav-fichas').classList.add('active');
</script>
@endsection






