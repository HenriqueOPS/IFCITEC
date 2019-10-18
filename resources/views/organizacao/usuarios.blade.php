@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">

			<div class="col-md-12 text-center">
				<h2>Painel do Organizador</h2>
			</div>

			<div id="page" class="col-md-12">
				<ul class="nav nav-pills nav-pills-primary"  role="tablist">
					<li>
						<a href="{{ route('organizador') }}">
							<i class="material-icons">account_balance</i>
							Escolas
						</a>
					</li>
					<li>
						<a href="{{ route('organizacao.projetos') }}">
							<i class="material-icons">list_alt</i>
							Listar Projetos
						</a>
					</li>
					<li>
						<a href="{{ route('organizacao.presenca') }}">
							<i class="material-icons">account_circle</i>
							Presença
						</a>
					</li>
					<li class="active">
						<a href="{{route('organizacao.usuarios')}}">
							<i class="material-icons">person</i>
							Usuários
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<br><br>

	<div class="container">
		<div class="row">
			<div class="col-md-12 main main-raised">
				<div class="list-projects">
					<table class="table">
						<thead id="5">
						<div id="5">
							<tr>
								<th class="text-center">#</th>
								<th>Usuários</th>
								<th>E-mail</th>
								<th class="text-right"></th>
							</tr>
						</div>
						</thead>

						<tbody id="5">
						@foreach($usuarios as $key => $usuario)
							<tr>
								<td class="text-center">{{$key + 1}}</td>
								<td>{{$usuario->nome}}</td>
								<td>{{$usuario->email}}</td>
								<td class="text-right">

								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</div>
@endsection
