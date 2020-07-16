@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="row">

			<div class="col-md-12 main main-raised">

				<div class="col-md-12 text-center">
					<h2>Cadastrar Nova Ficha</h2>
				</div>

				@if(!(\App\Edicao::consultaPeriodo('Feira')))
					<div class="col-md-12 text-center">
						<div class="alert alert-warning">
							<strong>Atenção!</strong> Antes de criar uma ficha, crie uma edição para o período atual
						</div>
					</div>
				@endif

				<form method="post" id="formulario" action="{{ route('adminstrador.salvarFicha') }}">

					{{ csrf_field() }}

					<div class="row">

						<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
								<div class="form-group">
									<label class="control-label">Nível</label>

									<select id="nivel-select" name="nivel" required>
										@foreach ($niveis as $nivel)
											@if ($nivel->id == old('nivel'))
												<option id="nivel" selected="selected" value="{{$nivel->id}}">{{$nivel->nivel}}</option>
											@else
												<option id="nivel" value="{{$nivel->id}}">{{$nivel->nivel}}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>


							<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
								<div class="form-group">
									<label class="control-label">Tipo</label>

									<select id="tipo-select" name="tipo" required>

										<option value="homologacao">Homologação</option>
										<option value="avaliacao">Avaliação</option>

									</select>
								</div>
							</div>


						</div>

					</div>


			<h3>Categorias:</h3>


			<div class="categorias"></div>


			<button class="btn btn-default btn-round align-center" type="button" onClick="adicionaCategoria()">
				<i class="material-icons">add</i> Adicionar Categoria
			</button>

			<hr>

			<div class="alert alert-danger" id="sendError">
				<div class="container-fluid">
					<div class="alert-icon">
						<i class="material-icons">error_outline</i>
					</div>

					<b>Oops:</b> <span class="error"></span>
				</div>
			</div>

			<div class="alert alert-success">
				<div class="container-fluid">
					<div class="alert-icon">
						<i class="material-icons">error_outline</i>
					</div>

					<b>Aeee:</b> Formulário Salvo com sucesso
				</div>
			</div>

			<input class="btn btn-success align-center" type="submit" value="Enviar" >

			</form>

			</div>
		</div>
	</div>


	<!-- TEMPLATE CATEGORIA -->
	<div id="template-categoria" style="display: none;">

		<div class="categoria" id-categoria="<% idCategoria %>">

			<a class="btn btn-danger  btn-sm btn-round removeCategoria" href="javascript:void(0)" onClick="removeCategoria(this)">
				<i class="material-icons">clear</i> remover categoria
			</a>

			<div class="row">
				<div class="col-md-6">

					<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">format_size</i>
					</span>
						<div class="form-group label-floating">
							<label class="control-label">Nome da Categoria</label>
							<input type="text" class="form-control" name="categorias[<% idCategoria %>][nome]" required>
						</div>
					</div>

				</div>

				<div class="col-md-6">

					<div class="input-group">
					<span class="input-group-addon">
						<i class="material-icons">poll</i>
					</span>
						<div class="form-group label-floating">
							<label class="control-label">Peso da Categoria</label>
							<input type="number" class="form-control" min="0" max="10" name="categorias[<% idCategoria %>][peso]" required>
						</div>
					</div>

				</div>
			</div>

			<h4>Campos:</h4>

			<div class="campos-categoria"></div>

			<button class="btn btn-default btn-round align-center" onClick="adicionaCampo(this)" type="button">
				<i class="material-icons">add</i> Adicionar Campo
			</button>

		</div>

	</div>
	<!-- FIM TEMPLATE CATEGORIA -->

	<!-- TEMPLATE CAMPO -->
	<div id="template-campo" style="display: none;">

		<div class="row campo">

			<div class="col-md-6">
				<div class="form-group">
					<input type="text" name="categorias[<% idCategoria %>][campos][<% idCampo %>][nome]" placeholder="Nome do campo" class="form-control" />
				</div>
			</div>

			<div class="col-md-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="categorias[<% idCategoria %>][campos][<% idCampo %>][0]" value="1" checked>
						0
					</label>
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="categorias[<% idCategoria %>][campos][<% idCampo %>][25]" value="1" checked>
						0,25
					</label>
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="categorias[<% idCategoria %>][campos][<% idCampo %>][50]" value="1" checked>
						0,5
					</label>
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="categorias[<% idCategoria %>][campos][<% idCampo %>][75]" value="1" checked>
						0,75
					</label>
				</div>
			</div>
			<div class="col-md-1">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="categorias[<% idCategoria %>][campos][<% idCampo %>][100]" value="1" checked>
						1
					</label>
				</div>
			</div>

			<div class="col-md-1">
				<button class="btn btn-default btn-fab btn-fab-mini btn-sm btn-round" type="button" onclick="removeCampo(this)">
					<i class="material-icons">clear</i>
				</button>
			</div>

		</div>

	</div>
	<!-- FIM TEMPLATE CAMPO -->

@endsection

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

<style>
.align-center {
	display: block;
	margin: 15px auto 10px;
}

.categorias .categoria {
	background: #f7f7f7;
	padding: 15px 10px;
	margin: 10px 0;
}

.categorias .categoria .removeCategoria {
	margin-left: calc(100% - 175px);
}

.categorias .categoria .row {margin: 0;}

.categorias .categoria h4 {
	color: #666666;
	font-weight: 500;
	margin-top: 20px;
	margin-bottom: 10px;
}

.categorias .categoria .campo {
	padding: 20px 0 10px 0;
	margin-bottom: 10px;
	background: #eee;

}

.categorias .categoria .campo .form-group {margin-top: 3px;}
</style>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

<script>
$(document).ready(function () {

	var oldNivel = $('#nivel-select').attr("value");
	$('#nivel-select').selectize({
		placeholder: 'Selecione o nível da ficha',
		onInitialize: function () {
			this.setValue(oldNivel, true);
			$('.selectize-input').addClass('form-control');
		},
	});

	var oldTipo = $('#tipo-select').attr("value");
	$('#tipo-select').selectize({
		placeholder: 'Selecione o tipo da ficha',
		onInitialize: function () {
			this.setValue(oldTipo, true);
			$('.selectize-input').addClass('form-control');
		},
	});

	$('#sendError').hide();
	$('.alert-success').hide();
});

var countCategoria = 0;
var countCampo = 0;

adicionaCategoria(); // init

function adicionaCategoria () {
	var templateCategoria = $('#template-categoria').html();
    templateCategoria = templateCategoria.replace(/<% idCategoria %>/g, countCategoria++);

	var categoria = $(templateCategoria).appendTo('div.categorias');

	adicionaCampo(categoria.children('h4'));
}

function removeCategoria (element) {
	$(element).parents('.categoria').remove();
}

function adicionaCampo(element) {

    var idCategoria = $(element).parent().attr('id-categoria');

	var templateCampo = $('#template-campo').html();
    templateCampo = templateCampo.replace(/<% idCategoria %>/g, idCategoria);
    templateCampo = templateCampo.replace(/<% idCampo %>/g, countCampo++);

	$(templateCampo).appendTo($(element).siblings('.campos-categoria'));
}

function removeCampo (element) {
	$(element).parents('.campo').remove();
}

// envia o formulário via ajax
$('#formulario').submit(function (e) {
	e.preventDefault();

	var formSerialized = $('#formulario').serialize();

	$.post('{{ route('adminstrador.salvarFicha') }}', formSerialized)
		.done(function () {
			$('.alert-success').show();
		})
		.fail(function (res) {
            $('#sendError').show();
            $('#sendError .error').html(res.responseJSON.error);

			console.log(res);
		});

});
</script>
@endsection
