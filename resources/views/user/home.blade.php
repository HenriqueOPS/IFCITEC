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

					<div id="0" class="list-projects ">

						@if(count($projetos['autor']) == 0)
							<h3 class="text-center">Você não é <b>Autor</b> em nenhum Projeto</h3>
						@endif

						@foreach($projetos['autor'] as $projeto)
				
							<div class="project col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1"  >
								<div class="project-title">
									<span><a href="{{ route('projeto.show', ['projeto' => $projeto->id]) }}">{{ $projeto->titulo }}</a></span>
								</div>
								<div class="project-info">
									Integrantes:
									@foreach($projeto->pessoas as $pessoa)
										{{$pessoa->nome}},
									@endforeach
								</div>
								<?php
						
						$dataCitada = \Carbon\Carbon::parse($datahom);
						$umDiaDepois = $dataCitada->copy()->addSecond();
						?>
								@if(isset($projetos['autor'][0]->nota_revisao) && $projetos['autor'][0]->nota_revisao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($umDiaDepois) )
							
								<strong>Nota da Homologação: {{ number_format($projeto->nota_revisao, 2) }}</strong>

								@endif
								<br>
								@if(isset($projetos['autor'][0]->nota_avaliacao) && $projetos['autor'][0]->nota_avaliacao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($umDiaDepois))					
							<strong>Nota da Avaliacao: {{  number_format($projeto->nota_avaliacao,2) }}</strong>
							@endif
							</div>
							
							@if(isset($projetos['autor'][0]->nota_revisao) && $projetos['autor'][0]->nota_revisao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($umDiaDepois) )
							
						
								
						<div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-offset-1 text-center">
                            <h2>Homologação:</h2>
					
                        </div>
                    </div>
                   
                    <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                 <strong>Nota do Homologador 1: </strong>{{ number_format($homologacao[0][0]->nota_final, 2)}}
							
                                </div>
                    </div>
					@foreach($homologacao[0] as $campo)
					<div class="row">
						<div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<strong>Categoria: {{$campo->categoria_avaliacao}}, Descrição: {{ $campo->descricao }}, Peso {{$campo->peso}}:</strong> {{$campo->valor}}
						</div>
					</div>
				@endforeach
				
					
                    <div class="row" id="selects">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                               
                                  
                                 <strong>Observação do Homologador 1: </strong>{{$homologacao[0][0]->observacao}}
                               
                            </div>
                    </div>
                    <hr>
                  
                    <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <strong>Nota do Homologador 2: </strong> {{ number_format($homologacao[1][0]->nota_final, 2)}}
                                </div>
								
                    </div>
					@foreach($homologacao[1] as $campo)
					<div class="row">
						<div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<strong>Categoria: {{$campo->categoria_avaliacao}}, Descrição: {{ $campo->descricao }}, Peso {{$campo->peso}}:</strong> {{$campo->valor}}
						</div>
					</div>
				@endforeach
                 
					
                    <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                             
                                <strong>Observação do Homologador 2: </strong>  {{$homologacao[1][0]->observacao}}
                                
                            </div>
                    </div>

							@endif
							<?php
						
						$dataCitada = \Carbon\Carbon::parse($dataava);
						$umDiaDepois = $dataCitada->copy()->addSecond();
						?>
							
						
							@if(isset($projetos['autor'][0]->nota_avaliacao) && $projetos['autor'][0]->nota_avaliacao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($umDiaDepois))					
						<div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-offset-1 text-center">
                            <h2>Avaliacão:</h2>
                        </div>
                    </div>
                   
                    <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                 <strong>Nota do Avaliador 1: </strong>{{ number_format($avaliacao[0][0]->nota_final, 2)}}
							
                                </div>
                    </div>
					@foreach($avaliacao[0] as $campo)
					<div class="row">
						<div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<strong>Categoria: {{$campo->categoria_avaliacao}}, Descrição: {{ $campo->descricao }}, Peso {{$campo->peso}}:</strong> {{$campo->valor}}
						</div>
					</div>
				@endforeach
				
					
                    <div class="row" id="selects">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                               
                                  
                                 <strong>Observação do Avaliador 1: </strong>{{$avaliacao[0][0]->observacao}}
                               
                            </div>
                    </div>
                    <hr>
                  @if(array_key_exists(1,$avaliacao))
                    <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <strong>Nota do Avaliador 2: </strong> {{ number_format($avaliacao[1][0]->nota_final, 2)}}
                                </div>
								
                    </div>
					@foreach($avaliacao[1] as $campo)
					<div class="row">
						<div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<strong>Categoria: {{$campo->categoria_avaliacao}}, Descrição: {{ $campo->descricao }}, Peso {{$campo->peso}}:</strong> {{$campo->valor}}
						</div>
					</div>
				@endforeach
                 
					
                    <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                             
                                <strong>Observação do Homologador 2: </strong>  {{$avaliacao[1][0]->observacao}}
                                
                            </div>
                    </div>
					@endif
							@endif

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
