@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Cadastro de Comissão Avaliadora</h2>
                        </div>
                    </div>

					@if ($temCadastro)

						<div class="row">
							<div class="col-md-12">
								<h4 style="text-align: center;">Você já se cadastrou para fazer parte da comissão avaliadora</h4>
							</div>
						</div>

					@else

                    <form method="post" id="formulario" action="{{route('cadastroAvaliador')}}">

                        {{ csrf_field() }}
                        @if ($errors->any())
                    <div class="col-md-10 col-md-offset-1 col-xs-11">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                        <div class="row">
                       
                        <div class="col-md-12">
                        <div style="background-color:{{ $coravisos }}">
                            <div class="container-fluid">
                            <br>
                            <div>
                                <i class="material-icons" style="color: white;">info_outline</i>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="fechar-alerta">
                                <span aria-hidden="true"><i class="material-icons">clear</i></span>
                            </button>
                            </div>
                          
                            <div class="text-center" style="color: white;">
                                {!! $aviso !!}
                            </div>
                            </div>
                        </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                        $(document).ready(function() {
                            $('#fechar-alerta').click(function() {
                            $(this).closest('.col-md-12').hide();
                            });
                        });
                        </script>



                            
                            <div class="col-md-10 col-md-offset-1 col-xs-11">

                                <input type="hidden" name="inscricao" value="avaliacao">

                                <div class="input-group{{ $errors->has('titulacao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">bookmark</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Titulação Em...</label>
                                        <input type="text" class="form-control" name="titulacao" maxlength="190"
                                               value="{{isset($dados->titulacao) ? $dados->titulacao : ''}}">
                                    </div>
                                    @if ($errors->has('titulacao'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('titulacao') }}</strong>
                                </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('lattes') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">insert_link</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Link Lattes</label>
                                        <input type="url" class="form-control" name="lattes" maxlength="190"
                                               value="{{isset($dados->lattes) ? $dados->lattes : ''}}"
                                               required>
                                    </div>
                                    @if ($errors->has('lattes'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('lattes') }}</strong>
                                </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('profissao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">assignment_ind</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Profissão</label>
                                        <input type="text" class="form-control" name="profissao" maxlength="190"
                                               value="{{isset($dados->profissao) ? $dados->profissao : ''}}" required>
                                    </div>
                                    @if ($errors->has('profissao'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('profissao') }}</strong>
                                </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('instituicao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Instituição</label>
                                        <input type="text" class="form-control" name="instituicao" maxlength="190"
                                               value="{{isset($dados->instituicao) ? $dados->instituicao : ''}}"
                                               required>
                                    </div>
                                    @if ($errors->has('instituicao'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('instituicao') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <h4>Selecione as áreas do conhecimento que gostaria de avaliar/homologar, de acordo com
                                    o nível:</h4>
                                @if(is_array($niveis))
                                    @foreach($niveis as $n)
                                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                                            <p>Nível {{$n->nivel}}:</p>
                                        </div>
                                        @foreach($areasConhecimento as $area)
                                            @if($area->nivel_id == $n->id)

                                                <div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"
                                                                   class="checkboxNivel{{$area->id}} checkboxArea"
                                                                   value="{{$area->id}}" name='area_id[]' >
                                                            {{$area->area_conhecimento}}
                                                        </label>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
                                    @endforeach
                                @else
                                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                                        <p>Nível {{$nivel->nivel}}:</p>
                                    </div>
                                    @foreach($areasConhecimento as $area)
                                        @if($area->nivel_id == $nivel->id)

                                            <div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"
                                                               class="checkboxNivel{{$area->id}} checkboxArea"
                                                               value="{{$area->id}}" name='area_id[]'>
                                                        {{$area->area_conhecimento}}
                                                    </label>
                                                </div>
                                            </div>

                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                                <h2>Endereço</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-11">

                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">my_location</i>
                                </span>
                                    <div class="form-group">
                                        <label class="control-label">CEP</label>
                                        <input type="text" class="form-control" name="cep" id="cep" maxlength="10"
                                               value="{{isset($data->cep) ? $data->cep : ''}}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                    <div class="form-group">
                                        <label class="control-label">Rua</label>
                                        <input type="text" class="form-control" name="endereco" id="rua" maxlength="100"
                                               value="{{isset($data->endereco) ? $data->endereco : ''}}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">near_me</i>
                                </span>
                                    <div class="form-group">
                                        <label class="control-label">Bairro</label>
                                        <input type="text" class="form-control" name="bairro" id="bairro" maxlength="40"
                                               value="{{isset($data->bairro) ? $data->bairro : ''}}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">near_me</i>
                                </span>
                                    <div class="form-group">
                                        <label class="control-label">Cidade</label>
                                        <input type="text" class="form-control" name="municipio" id="cidade" maxlength="40"
                                               value="{{isset($data->municipio) ? $data->municipio : ''}}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">near_me</i>
                                </span>
                                    <div class="form-group">
                                        <label class="control-label">Estado</label>
                                        <input type="text" class="form-control" name="uf" id="uf" maxlength="20"
                                               value="{{isset($data->uf) ? $data->uf : ''}}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">exposure_zero</i>
                                </span>
                                    <div class="form-group">
                                        <label class="control-label">Número</label>
                                        <input type="text" class="form-control" name="numero" maxlength="50"
                                               value="{{isset($data->numero) ? $data->numero : ''}}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-offset-1">
                                <p>Você pode escolher varios:</p>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="funcao[]" value="1">
                                        <span style="color: black">Quero ser Avaliador</span>
                                    </label>
                                </div>

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="funcao[]" value="2">
                                        <span style="color: black">Quero ser Homologador</span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button type="submit" class="btn btn-primary">Inscrever</button>
                            </div>
                        </div>
                    </form>
                  

					@endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript">

	$(document).ready(function () {

		function limpa_formulário_cep() {
			// Limpa valores do formulário de cep.
			$("#rua").val("");
			$("#bairro").val("");
			$("#cidade").val("");
			$("#uf").val("");
		}

		//Quando o campo cep perde o foco.
		$("#cep").blur(function () {

			//Nova variável "cep" somente com dígitos.
			var cep = $(this).val().replace(/\D/g, '');

			//Verifica se campo cep possui valor informado.
			if (cep != "") {

				//Expressão regular para validar o CEP.
				var validacep = /^[0-9]{8}$/;

				//Valida o formato do CEP.
				if (validacep.test(cep)) {

					//Preenche os campos com "..." enquanto consulta webservice.
					$("#rua").val("...");
					$("#bairro").val("...");
					$("#cidade").val("...");
					$("#uf").val("...");
					$("#ibge").val("...");

					//Consulta o webservice viacep.com.br/
					$.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

						if (!("erro" in dados)) {
							//Atualiza os campos com os valores da consulta.
							$("#rua").val(dados.logradouro);
							$("#bairro").val(dados.bairro);
							$("#cidade").val(dados.localidade);
							$("#uf").val(dados.uf);
							$("#ibge").val(dados.ibge);
						} //end if.
						else {
							//CEP pesquisado não foi encontrado.
							limpa_formulário_cep();
							alert("CEP não encontrado.");
						}
					});
				} //end if.
				else {
					//cep é inválido.
					limpa_formulário_cep();
					alert("Formato de CEP inválido.");
				}
			} //end if.
			else {
				//cep sem valor, limpa formulário.
				limpa_formulário_cep();
			}
		});



    var $submitBtn = $('button[type="submit"]');
    var $funcaoCheckboxes = $('[name="funcao[]"]');
    var $areaCheckboxes = $('[name="area_id[]"]');

    $submitBtn.attr('disabled', 'disabled');

    function updateSubmitButton() {
        var funcaoSelected = $funcaoCheckboxes.is(':checked');
        var areaSelected = $areaCheckboxes.is(':checked');

        $submitBtn.prop('disabled', !(funcaoSelected && areaSelected));
    }

    $funcaoCheckboxes.add($areaCheckboxes).on('change', updateSubmitButton);

	});

</script>
@endsection
