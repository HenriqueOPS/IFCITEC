@extends('layouts.app')

@section('content')
<div class="container">

	<div class="main main-raised">

		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<h2 class="text-center">Titulo do projeto</h2>
			</div>
		</div>

		<form id="formulario">

			{{ csrf_field() }}

			<input type="hidden" name="idProjeto" value="1">
			<input type="hidden" name="idAvaliador" value="2">

		<div class="categoria-form">

			<h3>Resumo</h3>

			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Capacidade de síntese e adequação de linguagem</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a1" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a1" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a1" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a1" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a1" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>


			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Definição do problema e justificativa</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a2" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a2" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a2" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a2" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a2" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>


			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Objetivos</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a3" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a3" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a3" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a3" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a3" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>


			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Metodologia</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a4" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a4" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a4" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a4" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a4" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>


			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Resultados parciais ou finais e/ou conclusões</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a5" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a5" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a5" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a5" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a5" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>

		</div>



		<div class="categoria-form">

			<h3>Pôster</h3>

			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Há pôster de apresentação do projeto no estande.</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a6" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a6" value="25" disabled>
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a6" value="50" disabled>
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a6" value="75" disabled>
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a6" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>


			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Definição do problema e justificativa</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a7" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a7" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a7" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a7" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a7" value="100">
						<strong>Ótimo</strong>
					</label>
				</div>
			</div>


			<div class="row categoria-item">
				<div class="col-md-7">
					<span class="item-title">Definição do problema e justificativa</span>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a8" value="0">
						<strong>Não Apresenta</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a8" value="25">
						<strong>Insuficiente</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a8" value="50">
						<strong>Regular</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a8" value="75">
						<strong>Bom</strong>
					</label>
				</div>

				<div class="col-md-1 radio-wrapper">
					<label>
						<input type="radio" name="a8" value="100">
						<strong>Ótimo</strong>
					</label>
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
var numCampos = 5;
numCampos += 3; // inclui idProjeto, idAvaliador e csrf_token

$('.alert-warning').hide();

function changeSubmitButton() {
	var formSerialized = $('#formulario').serializeArray();

	// ainda não preencheu todos os campos
	if (formSerialized.length < numCampos) {
		$('input[type=submit]').attr('disabled','disabled');
		$('.alert-warning').show();
	} else { // preencheu todos os campos
		$('input[type=submit]').removeAttr('disabled');
		$('.alert-warning').hide();
	}

	localStorage.setItem('ifcitecForm', JSON.stringify(formSerialized));
}

$('input[type=radio]').change(changeSubmitButton);

$(document).ready(function () {

	// recupera o formulario
	if (localStorage.getItem('ifcitecForm')) {

		var latestData = JSON.parse(localStorage.getItem('ifcitecForm'));

		var idProjeto = latestData.filter(function (field) { return field.name === 'idProjeto'; })

		if (idProjeto.length && $('input[name=idProjeto]').val() == idProjeto[0].value) {

			// remove os campos que não são checkbox
			latestData = latestData.filter(function (field) {
				switch (field.name) {
					case 'idAvaliador':
					case 'idProjeto':
					case '_token':
						return false;

					default:
						return true;
				}
			});

			latestData.forEach(function (field) {
				$('input[type=radio][name=' + field.name + '][value=' + field.value + ']').attr('checked', 'checked');
			});

			changeSubmitButton()

		}
	}

});

</script>
@endsection
