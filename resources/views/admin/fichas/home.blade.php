@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h2>Painel administrativo</h2>
			</div>

			<div id="page" class="col-md-12">
				<ul class="nav nav-pills nav-pills-primary"  role="tablist">
					<li>
						<a href="{{route('administrador')}}">
							<i class="material-icons">adjust</i>
							Edições
						</a>
					</li>
					<li>
						<a href="{{route('administrador.escolas')}}">
							<i class="material-icons">account_balance</i>
							Escolas
						</a>
					</li>
					<li>
						<a href="{{route('administrador.niveis')}}">
							<i class="material-icons">school</i>
							Níveis
						</a>
					</li>
					<li>
						<a href="{{route('administrador.areas')}}">
							<i class="material-icons">brightness_auto</i>
							Áreas
						</a>
					</li>
					<li class="active">
						<a href="{{route('administrador.ficha')}}">
							<i class="material-icons">list_alt</i>
							Fichas
						</a>
					</li>
					<li>
						<a href="{{route('administrador.tarefas')}}">
							<i class="material-icons">title</i>
							Tarefas
						</a>
					</li>
					<li>
						<a href="{{route('administrador.usuarios')}}">
							<i class="material-icons">person</i>
							Usuários
						</a>
					</li>
					<li>
						<a href="{{route('administrador.projetos')}}">
							<i class="material-icons">list_alt</i>
							Listar Projetos
						</a>
					</li>
					<li>
						<a href="{{route('administrador.comissao')}}">
							<i class="material-icons">list_alt</i>
							Comissão Avaliadora
						</a>
					</li>
					<li>
						<a href="{{route('administrador.relatoriosEdicao')}}">
							<i class="material-icons">description</i>
							Relatórios
						</a>
					</li>

				</ul>
			</div>
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
						<a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
					</div>
				</div>

			@endforeach

			</div>

		</div>
	</div>
</div>
@endsection






