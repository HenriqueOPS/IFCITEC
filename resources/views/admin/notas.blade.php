@extends('layouts.app')

@section('css')
	<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
	<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

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
					<li class="active">
						<a href="{{route('administrador.notas')}}">
							<i class="material-icons">note_add</i>
							Notas
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
		<form method="post" action="{{route('administrador.escolheProjeto')}}">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-md-12 main main-raised">
					<div class="input-group{{ $errors->has('projeto') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
						<div class="form-group">
							<label class="control-label">Projeto</label>
							<select id="projeto-select" name="projeto" value="{{old('projeto') ? old('projeto'): ''}}" required>
								<option></option>
								@foreach ($projetos as $projeto)
									@if ($projeto->id == old('projeto'))
										<option selected="selected" value="{{$projeto->id}}">{{$projeto->titulo}}</option>
									@else
										<option value="{{$projeto->id}}">{{$projeto->titulo}}</option>

									@endif
								@endforeach
							</select>

							@if ($errors->has('projeto'))
								<span class="help-block">
                                        <strong>{{ $errors->first('projeto') }}</strong>
                                    </span>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-md-offset-3 text-center">
							<button class="btn btn-primary">Enviar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection

@section('js')

	<script src="{{asset('js/main.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
	<script type="application/javascript">
		$(document).ready(function () {

			var oldProjeto = $('#projeto-select').attr("value");
			$('#projeto-select').selectize({
				placeholder: 'Escolha um projeto...',
				onInitialize: function () {
					this.setValue(oldProjeto, true);
					//$('.selectize-control').addClass('form-group');
					$('.selectize-input').addClass('form-control');
				},
			});
		});
	</script>

@endsection
