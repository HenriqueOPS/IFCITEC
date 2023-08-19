@extends('layouts.app')

@section('css')
	<style>
		.no-js #loader { display: none;  }
		.js #loader { display: block; position: absolute; top: 0; }
		.se-pre-con {
			position: fixed;
			left: 520px;
			top: 350px;
			width: 3%;
			height: 3%;
			z-index: 1;
		}
	</style>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-12">
				<div class="main main-raised">
					<div class="row">
						<div class="col-md-10 col-md-offset-1 text-center">
							<h2>Cadastro de Voluntário</h2>
						</div>
					</div>

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

					<div class="panel-body">
						<form method="POST" id="cadastraVoluntario" action="{{route('cadastraVoluntario')}}">

							{{ csrf_field() }}

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
                          
                            <div class="text-center">
                                {!! $aviso !!}
                            </div>
                            </div>
                        </div>
						<div class="row">

									<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
							<div class="col-md-12 text-center">
								<h3>Meus Dados</h3>
							</div>

							<div class="input-group{{ $errors->has('nome') ? ' has-error' : '' }}">
								<span class="input-group-addon">
									<i class="material-icons">face</i>
								</span>
								<div class="form-group label-floating">
									<label class="control-label">Nome</label>
									<input style="text-transform: capitalize" type="text" class="form-control"
										name="nome" value="{{ isset($pessoa->nome) ? $pessoa->nome : '' }}" required>
								</div>
								@if ($errors->has('nome'))
									<span class="help-block">
										<strong>{{ $errors->first('nome') }}</strong>
									</span>
								@endif
								
							</div>
							<div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ isset($pessoa->email) ? $pessoa->email : '' }}" required>
                                    </div>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
								<div class="input-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">perm_phone_msg</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Whatsapp</label>
                                        <input type="tel" OnKeyPress="formatar('## #####-####', this)"
                                            class="form-control" name="telefone" maxlength="13"
                                            value="{{ $pessoa->telefone ?? '' }}" required>
                                    </div>
                                    @if ($errors->has('telefone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('telefone') }}</strong>
                                        </span>
                                    @endif
                                </div>
							
							<div class="input-group ">
								
									<span class="input-group-addon">
										<i class="material-icons">school</i>
									</span>
									<label class="control-label">Curso</label>
								<select class="form-control" name="curso" required>
									<option value="" disabled selected>Escolha uma opção</option>
									<option value="DS">DS</option>
									<option value="ADM">ADM</option>
									<option value="ELE">ELE</option>
								</select>
							
							</div>

							<div class="input-group ">
								
								<span class="input-group-addon">
									<i class="material-icons">date_range</i>
								</span>
								<label class="control-label">Ano</label>
							<select class="form-control" name="ano" required>
								<option value="" disabled selected>Escolha uma opção</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
							</select>
						
						</div>
	
						
		

					

								
		
						

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                        $(document).ready(function() {
                            $('#fechar-alerta').click(function() {
                            $(this).closest('.col-md-12').hide();
                            });
                        });
                        </script>
								<div class="row">
									<div class="col-md-6 col-md-offset-3 text-center">
										<button name="button" href="javascript:void(0);" class="btn btn-primary">Inscrever</button>

									</div>
								</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript">
        $(document).ready(function () {

            let frm = $('#cadastraVoluntario');

            frm.submit(function(event) {

                $('#loadCadastro').removeClass('hide');

            });
        });
	</script>
@endsection

