@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-12">
				<ul class="main main-raised">
					<div class="row">
						<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
							<h2>Homologação de Comissão Avaliadora</h2>
						</div>
					</div>

					<div class="row">
						<h3 class="col-md-12 text-center">{{ $pessoa->nome }}</h3>
						<span class="col-md-12 text-center">{{ $pessoa->email }}</span>
					</div>

					<br>

					<div class="row">
						<div class="col-md-6 text-center">

							@if($pessoa->temFuncaoComissaoAvaliadora('Homologador'))
								<span class="label label-primary">Homologador</span>
							@endif

							@if($pessoa->temFuncaoComissaoAvaliadora('Avaliador'))
								<span class="label label-info">Avaliador</span>
							@endif

						</div>
						<div class="col-md-6 text-center">
							<a href="{{ $pessoa->lattes }}" target="_blank" class="btn btn-primary btn-sm">
								<i class="material-icons">link</i> Abrir Lattes
							</a>

						</div>
					</div>

					<div class="row">
					<strong class="col-md-5 col-md-offset-1">Data de Inscrição</strong>
						<span class="col-md-5 col-md-offset-1">{{ $comissaoEdicao->data_criacao }}</span>

						<strong class="col-md-5 col-md-offset-1">Instituição</strong>
						<span class="col-md-5 col-md-offset-1">{{ $pessoa->instituicao }}</span>

						<strong class="col-md-5 col-md-offset-1">Titulação</strong>
						<span class="col-md-5 col-md-offset-1">{{ $pessoa->titulacao }}</span>

						<strong class="col-md-5 col-md-offset-1">Profissão</strong>
						<span class="col-md-5 col-md-offset-1">{{ $pessoa->profissao }}</span>
					</div>

					<hr>

					<form method="POST" action="{{ route('homologaComissao') }}">

						{{ csrf_field() }}

						<input type="hidden" name="comissao_edicao_id" value="{{ $id }}">
						<input type="hidden" name="pessoa_id" value="{{ $pessoa->id }}">

						<div class="row">

							@foreach($nivel as $n)
								<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
									<p>Nível {{$n->nivel}}:</p>
								</div>
								@foreach($areasConhecimento as $area)
									@if($area->nivel_id == $n->id)

										<div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
											<div class="checkbox">
												<label>
													@if(in_array($area->id, $idsAreas))
														<input type="checkbox" checked
														   class="checkboxNivel{{$area->id}} checkboxArea"
														   value="{{$area->id}}" name='area_id[]'>
													@else
														<input type="checkbox"
															   class="checkboxNivel{{$area->id}} checkboxArea"
															   value="{{$area->id}}" name='area_id[]'>
													@endif
													{{$area->area_conhecimento}}
												</label>
											</div>
										</div>

									@endif
								@endforeach
							@endforeach

						</div>
						<br>
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-offset-1">
								<p>Você pode escolher varios:</p>
								@if($pessoa->temFuncao('Avaliador', TRUE))
								<div class="checkbox">
									<label>
										<input type="checkbox" name="avaliador" checked>
										<span style="color: black">Quero ser Avaliador</span>
									</label>
								</div>
								
								@endif
								@if($pessoa->temFuncao('Homologador', TRUE))
								<div class="checkbox">
									<label>
										<input type="checkbox" name="homologador"  checked>
										<span style="color: black">Quero ser Homologador</span>
									</label>
								</div>
							
								@endif
							</div>
						</div>
						<div class="row">
							<div class="col-md-6 col-md-offset-3 text-center">
								<button type="submit" class="btn btn-primary">Submeter</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
