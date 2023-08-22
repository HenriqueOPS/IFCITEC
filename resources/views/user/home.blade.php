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

	<br>

	<div class="container">

		<div class="row">

			<div class="col-md-12 main main-raised">

				<a href="{{ route('projeto.create') }}" class="btn btn-primary btn-round">
					<i class="material-icons">add</i> Novo Projeto
				</a>

				<table class="table">

					<tbody id="0">

					<div id="0" class="list-projects">

						@if(count($projetos['autor']) == 0)
							<h3 class="text-center">Você não é <b>Autor</b> em nenhum Projeto</h3>
						@endif

						@foreach($projetos['autor'] as $projeto)

							<div class="project">
								<div class="project-title">
									<span><a href="{{ route('projeto.show', ['projeto' => $projeto->id]) }}">{{ $projeto->titulo }}</a></span>
								</div>
								<div class="project-info">
									Integrantes:
									@foreach($projeto->pessoas as $pessoa)
										{{$pessoa->nome}},
									@endforeach
								</div>
							</div>
							@if(isset($projeto->nota_revisao) &&  $projeto->nota_revisao !== null)
								Nota revisao {{ $projeto->nota_revisao }},
							@endif
							@if(isset($projeto->nota_avaliacao) &&  $projeto->nota_avaliacao !== null)
								Nota avaliacao {{ $projeto->nota_avaliacao }},
							@endif
							<a href="{{route('notaProjeto',$projeto->id)}}"><i class="material-icons ">looks_one</i></a>
						@endforeach

					</div>

					</tbody>


					<tbody id="1">

					<div id="1" class="list-projects">

						@if(count($projetos['orientador']) == 0)
							<h3 class="text-center">Você não é <b>Orientador</b> em nenhum Projeto</h3>
						@endif

						@foreach($projetos['orientador'] as $projeto)

							<div class="project">
								<div class="project-title">
									<span><a href="{{ route('projeto.show', ['projeto' => $projeto->id]) }}">{{ $projeto->titulo }}</a></span>
								</div>
								<div class="project-info">
									Integrantes:
									@foreach($projeto->pessoas as $pessoa)
										{{$pessoa->nome}},
									@endforeach
								</div>
							</div>

						@endforeach

					</div>

					</tbody>


					<tbody id="2">

					<div id="2" class="list-projects">

						@if(count($projetos['coorientador']) == 0)
							<h3 class="text-center">Você não é <b>Coorientador</b> em nenhum Projeto</h3>
						@endif

						@foreach($projetos['coorientador'] as $projeto)

							<div class="project">
								<div class="project-title">
									<span><a href="{{ route('projeto.show', ['projeto' => $projeto->id]) }}">{{ $projeto->titulo }}</a></span>
								</div>
								<div class="project-info">
									Integrantes:
									@foreach($projeto->pessoas as $pessoa)
										{{$pessoa->nome}},
									@endforeach
								</div>
							</div>

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

		hideBodys();

		$('tbody[id=0]').show();
		$('div[id=0]').show();

		$('.tab').click(function () {
			var target = $(this)[0];

			hideBodys();

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
</script>
@endsection
