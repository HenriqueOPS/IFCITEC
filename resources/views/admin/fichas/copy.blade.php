@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="row">

			<div class="col-md-12 main main-raised">

				<div class="col-md-12 text-center">
					<h2>Copiar Ficha</h2>
				</div>

				<form method="post" id="formulario" action="{{ route('adminstrador.copiaFicha') }}">

					{{ csrf_field() }}

					<div class="row">

						<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1 text-center">
							<h3>Formulário a ser copiado</h3>
						</div>

						<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
								<div class="form-group">
									<label class="control-label">Edição</label>

									<select id="edicao-select" name="edicao" required>
										@foreach ($edicoes as $edicao)
											@if ($edicao->id == old('edicao'))
												<option selected="selected" value="{{$edicao->id}}">{{\App\Edicao::numeroEdicao($edicao->ano)}}</option>
											@else
												<option value="{{$edicao->id}}">{{\App\Edicao::numeroEdicao($edicao->ano)}}</option>
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
									<label class="control-label">Nível</label>

									<select class="nivel-select" name="nivel" required>
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

									<select class="tipo-select" name="tipo" required>

										<option value="homologacao">Homologação</option>
										<option value="avaliacao">Avaliação</option>

									</select>
								</div>
							</div>
						</div>


						<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1 text-center">
							<h3>Formulário a ser criado</h3>
						</div>

						<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
								<div class="form-group">
									<label class="control-label">Nível</label>

									<select class="nivel-select" name="nivel_copia" required>
										@foreach ($niveisEdicao as $nivel)
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

									<select class="tipo-select" name="tipo_copia" required>

										<option value="homologacao">Homologação</option>
										<option value="avaliacao">Avaliação</option>

									</select>
								</div>
							</div>
						</div>

					</div>


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

@endsection

@section('css')
	<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

	<style>
		.align-center {
			display: block;
			margin: 15px auto 10px;
		}
	</style>
@endsection

@section('js')
	<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

	<script>
        $(document).ready(function () {

            var oldNivel = $('.nivel-select').attr("value");
            $('.nivel-select').selectize({
                placeholder: 'Selecione o nível da ficha',
                onInitialize: function () {
                    this.setValue(oldNivel, true);
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldEdicao = $('#edicao-select').attr("value");
            $('#edicao-select').selectize({
                placeholder: 'Selecione a edição da ficha',
                onInitialize: function () {
                    this.setValue(oldNivel, true);
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldTipo = $('.tipo-select').attr("value");
            $('.tipo-select').selectize({
                placeholder: 'Selecione o tipo da ficha',
                onInitialize: function () {
                    this.setValue(oldTipo, true);
                    $('.selectize-input').addClass('form-control');
                },
            });

            $('#sendError').hide();
            $('.alert-success').hide();
        });


        // envia o formulário via ajax
        $('#formulario').submit(function (e) {
            e.preventDefault();

            var formSerialized = $('#formulario').serialize();

            $.post('{{ route('adminstrador.copiaFicha') }}', formSerialized)
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
