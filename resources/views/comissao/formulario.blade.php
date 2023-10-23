@extends('layouts.app')

@section('content')
<div class="container">

	<div class="main main-raised">

		<div class="row hide" id="loadCadastro">

			<div class="loader loader--style2" title="1">
				<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="80px" height="80px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
					  <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
						  <animateTransform attributeType="xml"
								attributeName="transform"
								type="rotate"
								from="0 25 25"
								to="360 25 25"
								dur="0.6s"
								repeatCount="indefinite"/>
					  </path>
				</svg>
			</div>

		</div>

		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">{{ $projeto->titulo }}</h2>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4>Resumo</h4>
				@php
				$resumoLength = strlen($projeto->resumo);
			@endphp
				<p class="resumo">{{ $projeto->resumo }}</p>

				<hr>
				<p><b>Contagem de caracteres do resumo:</b> {{ $resumoLength }}</p>


				<b>Palavras-Chaves:</b>
				@foreach($projeto->palavrasChaves as $palavra)
					{{ $palavra->palavra }};
				@endforeach
				<br /><br />

				<b>Nível:</b>
				<span>{{ $projeto->nivel->nivel }}</span>
				<br /><br />

				<b>Área do Conhecimento:</b>
				<span>{{ $projeto->areaConhecimento->area_conhecimento }}</span>
				<hr>
			</div>
		</div>

		@if($tipo == 'avaliacao')

		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-danger  btn-sm btn-round" id="naoCompareceu">
					<i class="material-icons">layers_clear</i> Projeto não compareceu
				</button>
			</div>
		</div>

		@endif

		<form id="formulario" method="post" action="{{ route('enviarFormulario') }}">

			{{ csrf_field() }}

			<input type="hidden" name="tipo" value="{{ $tipo }}">
			<input type="hidden" name="idProjeto" value="{{ $projeto->id }}">

			@foreach($categorias as $categoria)

			<div class="categoria-form">

				<h3>{{ $categoria->categoria_avaliacao }}</h3>

				@foreach($categoria->campos as $campo)

				<div class="row categoria-item">
					<div class="col-md-7">
						<span class="item-title">{{ $campo->descricao }}</span>
					</div>

					<div class="col-md-1 radio-wrapper">
						<label>
							<input type="radio" name="categorias[{{$categoria->categoria_avaliacao_id}}][{{ $campo->id }}]" value="0" {{ !$campo->val_0 ? 'disabled' : '' }}>
							<strong>Não Apresenta</strong>
						</label>
					</div>

					<div class="col-md-1 radio-wrapper">
						<label>
							<input type="radio" name="categorias[{{$categoria->categoria_avaliacao_id}}][{{ $campo->id }}]" value="25" {{ !$campo->val_25 ? 'disabled' : '' }}>
							<strong>Insuficiente</strong>
						</label>
					</div>

					<div class="col-md-1 radio-wrapper">
						<label>
							<input type="radio" name="categorias[{{$categoria->categoria_avaliacao_id}}][{{ $campo->id }}]" value="50" {{ !$campo->val_50 ? 'disabled' : '' }}>
							<strong>Regular</strong>
						</label>
					</div>

					<div class="col-md-1 radio-wrapper">
						<label>
							<input type="radio" name="categorias[{{$categoria->categoria_avaliacao_id}}][{{ $campo->id }}]" value="75" {{ !$campo->val_75 ? 'disabled' : '' }}>
							<strong>Bom</strong>
						</label>
					</div>

					<div class="col-md-1 radio-wrapper">
						<label>
							<input type="radio" name="categorias[{{$categoria->categoria_avaliacao_id}}][{{ $campo->id }}]" value="100" {{ !$campo->val_100 ? 'disabled' : '' }}>
							<strong>Ótimo</strong>
						</label>
					</div>
				</div>

				@endforeach

			</div>

			@endforeach

		<div class="categoria-form">

			<h3>Observação</h3>

			<div class="row">
				<div class="col-md-12">
					<textarea name="observacao" class="form-control" placeholder="Escreva aqui suas impressões para melhorias do trabalho" rows="5"></textarea>
					<span style="color: #ff1744; font-size: 10px;">campo obrigatório</span>
				</div>
			</div>

		</div>

		<div class="alert alert-warning">
			<div class="container-fluid">
				<div class="alert-icon">
					<i class="material-icons">warning</i>
				</div>

				<b>Oops:</b> É necessário preencher todos os tópicos do formulário para enviar
			</div>
		</div>

		<div class="alert alert-danger">
			<div class="container-fluid">
				<div class="alert-icon">
					<i class="material-icons">error_outline</i>
				</div>

				<b>Oops:</b> Ocorreu um erro ao tentar enviar o formulário, favor comunicar a organização da feira
			</div>
		</div>

		<div class="wrapper-button">
			<input type="submit" class="btn btn-success" value="Enviar" disabled>
		</div>

		</form>

	</div>

</div>

@endsection

@section('css')
<style>
.row {
	margin-left: 0;
	margin-right: 0;
}

.wrapper-button {
	width: 100%;
	text-align: center;
}

.categoria-form {
	margin: 10px 10px 30px 10px;
	padding-bottom: 50px;
	border-bottom: 1px solid #f2f2f2;
}

.categoria-item {
	width: 100%;
	padding: 10px 0;

}
.categoria-item:nth-child(2n) {
	background: #f9f9f9;
}

.categoria-item .item-title{
	font-size: 16px;
	margin-top: 10px;
	display: block;
}

.categoria-item .radio-wrapper {
	padding-left: 5px;
	padding-right: 5px;
}

.categoria-item .radio-wrapper label {
	width: 100%;
	text-align: center;
}

.categoria-item .radio-wrapper label input[type=radio] {
	width: 18px;
	height: 18px;
	display: block;
	clear: both;
	margin: 5px auto 10px auto;
}

.categoria-item .radio-wrapper label strong {
	width: 100%;
	height: 50px;
	clear: both;
	display: flex;
	justify-content: center; /* align horizontal */
	align-items: center; /* align vertical */
	font-size: 13px;
	color: #848383;
}

.categoria-item .radio-wrapper label input[type=radio][disabled] + strong{color: #c1c1c1;}

@media (max-width: 992px) {
	.categoria-item .radio-wrapper {
		width: 20%;
		float: left;
		padding-left: 3px;
		padding-right: 3px;
	}
	.categoria-item .item-title{margin-bottom: 15px;}
}

@media (max-width: 720px) {
	.categoria-item .radio-wrapper label strong {font-size: 11px;}
}

</style>
@endsection

@section('js')
<script>
var numCampos = {{ $countCampos }}; // numero de radio buttons
numCampos += 4; // inclui tipo, idProjeto, csrf_token e observacao

$('.alert-warning').hide();
$('.alert-danger').hide();

function changeSubmitButton() {
	var formSerialized = $('#formulario').serializeArray();

	// ainda não preencheu todos os campos
	if (formSerialized.length < numCampos || $('[name="observacao"]').val() == '') {
		$('input[type=submit]').attr('disabled','disabled');
		$('.alert-warning').show();
	} else { // preencheu todos os campos
		$('input[type=submit]').removeAttr('disabled');
		$('.alert-warning').hide();
	}

	// salva uma cópia em localStorage para evitar problemas
	localStorage.setItem('ifcitecForm', JSON.stringify(formSerialized));
}

$('input[type=radio]').change(changeSubmitButton);
$('textarea[name=observacao]').change(changeSubmitButton);

$(document).ready(function () {

	// recupera o formulario
	if (localStorage.getItem('ifcitecForm')) {

		var latestData = JSON.parse(localStorage.getItem('ifcitecForm'));

		var idProjeto = latestData.filter(function (field) { return field.name === 'idProjeto'; })

		if (idProjeto.length && $('input[name=idProjeto]').val() == idProjeto[0].value) {

			// remove os campos que não são checkbox
			latestData = latestData.filter(function (field) {
				switch (field.name) {
					case 'idProjeto':
					case '_token':
						return false;

					default:
						return true;
				}
			});

			latestData.forEach(function (field) {
				if (field.name == 'observacao')
					$('textarea[name=observacao]').text(field.value)
				else
					$('input[type=radio][name="' + field.name + '"][value=' + field.value + ']').attr('checked', 'checked');
			});

			changeSubmitButton()
		}
	}

});

$('#naoCompareceu').click(function () {

    $('textarea[name=observacao]').text('Projeto não compareceu');
    $('input[type=radio][value="0"]').attr('checked', 'checked');

    $('input[type=submit]').removeAttr('disabled');
    $('.alert-warning').hide();

});

// envia o formulário via ajax
$('#formulario').submit(function (e) {
	e.preventDefault();

	$('#loadCadastro').removeClass('hide');

	var formSerialized = $('#formulario').serialize();

	$.post('{{ route('enviarFormulario') }}', formSerialized)
		.done(function () {
			// limpa o localStorage
			localStorage.removeItem('ifcitecForm');
			// redireciona para tela de comissão avaliadora
			location.href = '{{ route('comissao') }}';
		})
		.fail(function (data) {
			console.log(data);
			$('.alert-danger').show();
		})
		.always(function (data) {
			$('#loadCadastro').addClass('hide');
		});

});
</script>
@endsection
