@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="row">

			<div class="col-md-12 main main-raised">

				<div class="col-md-12 text-center">
					<h2>Editar Ficha</h2>
				</div>

				@if((\App\Edicao::consultaPeriodo('Avaliação')) && $formulario->tipo == 'avaliacao')
					<div class="col-md-12 text-center">
						<div class="alert alert-danger">
							<strong>Atenção!</strong> O perído de avaliação está aberto, realizar uma alteração agora pode não ser uma boa idéia!
						</div>
					</div>
				@endif

				@if((\App\Edicao::consultaPeriodo('Homologação')) && $formulario->tipo == 'homologacao')
					<div class="col-md-12 text-center">
						<div class="alert alert-danger">
							<strong>Atenção!</strong> O perído de homologação está aberto, realizar uma alteração agora pode não ser uma boa idéia!
						</div>
					</div>
				@endif

				<form method="post" id="formulario" action="{{ route('adminstrador.salvarFicha') }}">

					{{ csrf_field() }}

					<input type="hidden" name="id" value="{{$formulario->idformulario}}" />

					<div class="row">

						<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>

								<div class="form-group label-floating">
									<label class="control-label">Nível</label>
									<input type="text" class="form-control" value="{{$formulario->nivel}}" disabled />
								</div>
							</div>

							<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>

								<div class="form-group label-floating">
									<label class="control-label">Tipo</label>
									@if ($formulario->tipo == 'avaliacao')
										<input type="text" class="form-control" value="Avaliação" disabled />
									@else
										<input type="text" class="form-control" value="Homologação" disabled />
									@endif
								</div>
							</div>

						</div>

					</div>


					<h3>Categorias:</h3>

					<div class="categorias">



						@foreach($categorias as $categoria)
						<div class="categoria" id-categoria="{{$categoria->categoria_avaliacao_id}}">

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
											<input type="text" class="form-control" name="categorias[{{$categoria->categoria_avaliacao_id}}][nome]" required value="{{$categoria->categoria_avaliacao}}">
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
											<input type="number" class="form-control" min="0" max="10" name="categorias[{{$categoria->categoria_avaliacao_id}}][peso]" required value="{{$categoria->peso}}">
										</div>
									</div>

								</div>
							</div>

							<h4>Campos:</h4>

							<div class="campos-categoria">
								@foreach($categoria->campos as $campo)

									<div class="row campo">

										<div class="col-md-6">
											<div class="form-group">
												<input type="text" name="categorias[{{$categoria->categoria_avaliacao_id}}][campos][{{$campo->id}}][nome]" placeholder="Nome do campo" value="{{$campo->descricao}}" class="form-control" />
											</div>
										</div>

										<div class="col-md-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="categorias[{{$categoria->categoria_avaliacao_id}}][campos][{{$campo->id}}][0]" value="1" checked>
													0
												</label>
											</div>
										</div>
										<div class="col-md-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="categorias[{{$categoria->categoria_avaliacao_id}}][campos][{{$campo->id}}][25]" value="1" checked>
													0,25
												</label>
											</div>
										</div>
										<div class="col-md-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="categorias[{{$categoria->categoria_avaliacao_id}}][campos][{{$campo->id}}][50]" value="1" checked>
													0,5
												</label>
											</div>
										</div>
										<div class="col-md-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="categorias[{{$categoria->categoria_avaliacao_id}}][campos][{{$campo->id}}][75]" value="1" checked>
													0,75
												</label>
											</div>
										</div>
										<div class="col-md-1">
											<div class="checkbox">
												<label>
													<input type="checkbox" name="categorias[{{$categoria->categoria_avaliacao_id}}][campos][{{$campo->id}}][100]" value="1" checked>
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

								@endforeach
							</div>

							<button class="btn btn-default btn-round align-center" onClick="adicionaCampo(this)" type="button">
								<i class="material-icons">add</i> Adicionar Campo
							</button>

						</div>

						@endforeach

					</div>


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
            $('#sendError').hide();
            $('.alert-success').hide();
        });

        var countCategoria = 0;
        var countCampo = 0;

        function adicionaCategoria () {
            var templateCategoria = $('#template-categoria').html();
            templateCategoria = templateCategoria.replace(/<% idCategoria %>/g, '_' + countCategoria++);

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
            templateCampo = templateCampo.replace(/<% idCampo %>/g, '_' + countCampo++);

            $(templateCampo).appendTo($(element).siblings('.campos-categoria'));
        }

        function removeCampo (element) {
            $(element).parents('.campo').remove();
        }

        // envia o formulário via ajax
        $('#formulario').submit(function (e) {
            e.preventDefault();

            var formSerialized = $('#formulario').serialize();

            $.post('{{ route('administrador.alteraFicha') }}', formSerialized)
                .done(function () {
                    $('#sendError').hide();
                    $('.alert-success').show();
                })
                .fail(function (res) {
                    $('.alert-success').hide();
                    $('#sendError').show();
                    $('#sendError .error').html(res.responseJSON.error);

                    console.log(res);
                });

        });
	</script>
@endsection
