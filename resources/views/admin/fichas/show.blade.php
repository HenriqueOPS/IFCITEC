@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="main main-raised">

			<div class="row">
				<div class="col-md-12">
				@if($formulario['tipo'] == 'avaliacao')
					<h2 class="text-center">Ficha de Avaliação - {{$formulario['nivel']}}</h2>
				@else
					<h2 class="text-center">Ficha de Homologação - {{$formulario['nivel']}}</h2>
				@endif
				</div>
			</div>


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
