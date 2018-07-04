@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">

			<div class="col-md-12 text-center">
				<h2>Painel do Usuário</h2>
			</div>

			<div id="page" class="col-md-12">
				<ul class="nav nav-pills nav-pills-primary" role="tablist">

					<li class="active">
						<a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
							<i class="material-icons">person</i>
							Autor
						</a>
					</li>

					<li>
						<a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
							<i class="material-icons">person</i>
							Orientador
						</a>
					</li>

					<li>
						<a href="dashboard" id="2" class="tab" role="tab" data-toggle="tab">
							<i class="material-icons">person</i>
							Coorientador
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

				<table class="table">

					<thead id="0">

					<div id="0">
						<div class="col-md-12">
							<a href="{{route('projeto.create')}}" class="btn btn-primary btn-round">
								<i class="material-icons">add</i> Novo Projeto
							</a>
						</div>
					</div>

					</thead>

					<tbody id="0">

					<div id="0" class="list-projects">
						@foreach($projetosPessoa as $p)
							@foreach($projetos as $projeto)

								@if($p->projeto_id==$projeto->id && $p->funcao=='Autor')
									<div class="project">
										<div class="project-title">
											<span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
										</div>
										<div class="project-info">
											Integrantes:
											@foreach($integrantes as $integrante)
												@if($integrante->projeto_id == $projeto->id)
													{{$integrante->nome}},
												@endif
											@endforeach
										</div>
									</div>
								@endif

							@endforeach
						@endforeach
					</div>
					</tbody>


					<thead id="1">

					<div id="1">
						<div class="col-md-12">
							<a href="{{route('projeto.create')}}" class="btn btn-primary btn-round">
								<i class="material-icons">add</i> Novo Projeto
							</a>
						</div>
					</div>

					</thead>

					<tbody id="1">

					<div id="1" class="list-projects">
						@foreach($projetosPessoa as $p)
							@foreach($projetos as $projeto)

								@if($p->projeto_id==$projeto->id && $p->funcao=='Orientador')
									<div class="project">
										<div class="project-title">
											<span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
										</div>
										<div class="project-info">
											Integrantes:
											@foreach($integrantes as $integrante)
												@if($integrante->projeto_id == $projeto->id)
													{{$integrante->nome}},
												@endif
											@endforeach
										</div>
									</div>
								@endif

							@endforeach
						@endforeach
					</div>
					</tbody>


					<thead id="2">

					<div id="2">
						<div class="col-md-12">
							<a href="{{route('projeto.create')}}" class="btn btn-primary btn-round">
								<i class="material-icons">add</i> Novo Projeto
							</a>
						</div>
					</div>

					</thead>

					<tbody id="2">

					<div id="2" class="list-projects">
						@foreach($projetosPessoa as $p)
							@foreach($projetos as $projeto)

								@if($p->projeto_id==$projeto->id && $p->funcao=='Coorientador')
									<div class="project">
										<div class="project-title">
											<span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
										</div>
										<div class="project-info">
											Integrantes:
											@foreach($integrantes as $integrante)
												@if($integrante->projeto_id == $projeto->id)
													{{$integrante->nome}},
												@endif
											@endforeach
										</div>
									</div>
								@endif

							@endforeach
						@endforeach
					</div>
					</tbody>

				</table>
			</div>

		</div>
	</div>

@endsection
@section('js')
	<script type="application/javascript">
		$(document).ready(function () {

			hideHeads();
			hideBodys();
			$('thead[id=0]').show();
			$('tbody[id=0]').show();
			$('div[id=0]').show();
			$('.tab').click(function (e) {
				var target = $(this)[0];
				hideHeads();
				hideBodys();
				$('thead[id=' + target.id + ']').show();
				$('tbody[id=' + target.id + ']').show();
				$('div[id=' + target.id + ']').show();
			});

		});

		function hideBodys() {
			$('tbody[id=0]').hide();
			$('tbody[id=1]').hide();
			$('tbody[id=2]').hide();
			$('div[id=0]').hide();
			$('div[id=1]').hide();
			$('div[id=2]').hide();
		}

		function hideHeads() {
			$('thead[id=0]').hide();
			$('thead[id=1]').hide();
			$('thead[id=2]').hide();
			$('div[id=0]').hide();
			$('div[id=1]').hide();
			$('div[id=2]').hide();
		}
	</script>
@endsection
