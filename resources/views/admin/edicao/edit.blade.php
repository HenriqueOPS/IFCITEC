@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-sm-12">
				<div class="main main-raised">
					<div class="row">
						<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
							<h2>Alterar Edição</h2>
						</div>
					</div>
					<form method="post" action="{{route('edicao')}}">

						{{ csrf_field() }}

						<input type="hidden" name="id_edicao" value="{{ $dados->id }}">

						<!-- Período de Inscrição -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Período de Inscrição</h3>
								<span>Durante esse período será possivel submeter projetos</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('inscricao_abertura') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="inscricao_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->inscricao_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('inscricao_abertura'))
										<span class="help-block">
                                            <strong>{{ $errors->first('inscricao_abertura') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{ $errors->has('inscricao_fechamento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="inscricao_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->inscricao_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('inscricao_fechamento'))
										<span class="help-block">
                                       		 <strong>{{ $errors->first('inscricao_fechamento') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>
						</div>

						<!-- Período de Homologação -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Período de Homologação</h3>
								<span>Durante esse período será possivel homologar os projetos recebidos</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('homologacao_abertura') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="homologacao_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->homologacao_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('homologacao_abertura'))
										<span class="help-block">
                                        	<strong>{{ $errors->first('homologacao_abertura') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('homologacao_fechamento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="homologacao_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->homologacao_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('homologacao_fechamento'))
										<span class="help-block">
											<strong>{{ $errors->first('homologacao_fechamento') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>
						</div>

						<!-- Período de Avaliação -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Período de Avaliação</h3>
								<span>Durante esse período será possivel avaliar os projetos homologados (Dia da Feira)</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('avaliacao_abertura') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="avaliacao_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->avaliacao_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('avaliacao_abertura'))
										<span class="help-block">
                                       		 <strong>{{ $errors->first('avaliacao_abertura') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('avaliacao_fechamento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="avaliacao_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->avaliacao_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('avaliacao_fechamento'))
										<span class="help-block">
                                       		 <strong>{{ $errors->first('avaliacao_fechamento') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>
						</div>

						<!-- Período de Credenciamento -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Período de Credenciamento</h3>
								<span>Durante esse período será possivel realizar o credenciamento no evento (Dia da Feira)</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('credenciamento_abertura') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="credenciamento_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->credenciamento_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('credenciamento_abertura'))
										<span class="help-block">
                                        	<strong>{{ $errors->first('credenciamento_abertura') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('credenciamento_fechamento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="credenciamento_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->credenciamento_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('credenciamento_fechamento'))
										<span class="help-block">
                                        	<strong>{{ $errors->first('credenciamento_fechamento') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>
						</div>

						<!-- Período de Voluntário -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Período de Inscrição para Voluntário</h3>
								<span>Durante esse período será possivel se inscrever para atuar como voluntário durante a feira</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('voluntario_abertura') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="voluntario_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->voluntario_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('voluntario_abertura'))
										<span class="help-block">
                                        	<strong>{{ $errors->first('voluntario_abertura') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('voluntario_fechamento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="voluntario_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->voluntario_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('voluntario_fechamento'))
										<span class="help-block">
                                        	<strong>{{ $errors->first('voluntario_fechamento') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>
						</div>

						<!-- Período de Inscrição para Avaliador/Homologador -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 text-center">
								<h3>Período de Inscrição para Avaliador/Homologador</h3>
								<span>Durante esse período será possivel se inscrever para atuar como voluntário durante a feira</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('comissao_abertura') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="comissao_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->comissao_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('comissao_abertura'))
										<span class="help-block">
                                        	<strong>{{ $errors->first('comissao_abertura') }}</strong>
                                    	</span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('comissao_fechamento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="comissao_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->comissao_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('comissao_fechamento'))
										<span class="help-block">
                                        <strong>{{ $errors->first('comissao_fechamento') }}</strong>
                                    </span>
									@endif
								</div>
							</div>
						</div>

						<!-- Período da feira -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Período da Feira</h3>
								<span>Durante esse período será possivel acessar o sistema como Autor, Avaliador, Homologador e Organizador</span>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('feira_abertura') ? ' has-error' : '' }}">
							<span class="input-group-addon">
								<i class="material-icons">today</i>
							</span>
									<div class="form-group ">
										<label class="control-label">Início</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="feira_abertura"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->feira_abertura)) }}"
											   required>
									</div>
									@if ($errors->has('feira_abertura'))
										<span class="help-block">
                                        <strong>{{ $errors->first('feira_abertura') }}</strong>
                                    </span>
									@endif
								</div>
							</div>

							<div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
								<div class="input-group{{$errors->has('feira_fechamento') ? ' has-error' : '' }}">
							<span class="input-group-addon">
								<i class="material-icons">today</i>
							</span>
									<div class="form-group ">
										<label class="control-label">Fim</label>
										<input type="datetime-local" class="form-control datepicker"
											   name="feira_fechamento"
											   value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->feira_fechamento)) }}"
											   required>
									</div>
									@if ($errors->has('feira_fechamento'))
										<span class="help-block">
                                        <strong>{{ $errors->first('feira_fechamento') }}</strong>
                                    </span>
									@endif
								</div>
							</div>
						</div>

						<!-- Número de projetos da feira -->
						<div class="row">
							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<h3>Número de Projetos</h3>
								<span>Número de projetos que irão participar da feira</span>
							</div>

							<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
								<div class="input-group{{$errors->has('projetos') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">filter_9_plus</i>
                                </span>
									<div class="form-group ">
										<input type="number" class="form-control datepicker" name="projetos"
											   value="{{ $dados->projetos }}" required>
									</div>
									@if ($errors->has('projetos'))
										<span class="help-block">
                                        <strong>{{ $errors->first('projetos') }}</strong>
                                    </span>
									@endif
								</div>
							</div>
						</div>

						<div class="row">
							<div class="input-group{{ $errors->has('nivel_id[]') ? ' has-error' : '' }}">
								<div class="input-group{{ $errors->has('area_id[]') ? ' has-error' : '' }}">
									<div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
										<h3>Níveis e Áreas da edição</h3>
									</div>
									@foreach($n as $key=>$nivel)
										<div class="col-md-12 col-md-offset-1 col-xs-9 col-xs-offset-1">
											@if(in_array($nivel->id, $nivelEdicao))
												<div class="checkbox">
													<label>
														<input type="checkbox"
															   value="{{isset($nivel->id) ? $nivel->id : ''}}"
															   name="nivel_id[]" class="checkboxNivel checkboxNivel{{$nivel->id}}" checked>
														{{$nivel->nivel}}
													</label>
												</div>
											@else
												<div class="checkbox">
													<label>
														<input type="checkbox"
															   value="{{isset($nivel->id) ? $nivel->id : ''}}"
															   name="nivel_id[]"
															   class="checkboxNivel checkboxNivel{{$nivel->id}}">
														{{$nivel->nivel}}
													</label>
												</div>
											@endif
											@foreach($areas as $key=>$area)
												@if($area->nivel_id == $nivel->id)
													<div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
														@if(in_array($area->id, $areaEdicao))
															<div class="checkbox">
																<label>
																	<input type="checkbox"
																			class="checkboxNivel{{$nivel->id}} checkboxArea"
																		   value="{{isset($area->id) ? $area->id : ''}}"
																		   name="area_id[]" checked>
																	{{$area->area_conhecimento}}
																</label>
															</div>
														@else
															<div class="checkbox">
																<label>
																	<input type="checkbox"
																		   class="checkboxNivel{{$nivel->id}} checkboxArea"
																		   value="{{isset($area->id) ? $area->id : ''}}"
																		   name="area_id[]">
																	{{$area->area_conhecimento}}
																</label>
															</div>
														@endif
													</div>
												@endif
											@endforeach
										</div>
									@endforeach
									<div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
										@if ($errors->has('nivel_id[]'))
											<span class="help-block">
                                                <strong>{{ $errors->first('nivel_id[]') }}</strong>
                                            </span>
										@endif
										@if ($errors->has('area_id[]'))
											<span class="help-block">
                                                <strong>{{ $errors->first('area_id[]') }}</strong>
                                            </span>
										@endif
									</div>
								</div>
							</div>
						</div>

						<!-- Campos Extras -->
						<!--
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                <h3>Campos Extras</h3>
                                <span>Estes campos irão aparecer no formulário que o autor irá cadastrar o projeto</span>
                            </div>


                        </div>
                        -->

						<div class="row">
							<div class="col-md-6 col-md-offset-3 text-center">
								<button class="btn btn-primary">Salvar Alterações</button>
							</div>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
@section('js')
	<script type="text/javascript">
		$('.checkboxNivel').click(function (data) {

			//marca ou desmarca todas as areas quando seleciona o nivel
			let childNameClass = '.checkboxNivel' + $(this).val();
			let state = $($(this)).prop("checked");

			$(childNameClass).prop("checked", state);

		});

		$('.checkboxArea').click(function (data) {

			//marca o nivel qnd selecionou apenas a area
			let parent = $(this).prop('class').split(' ')[0];

			$('.checkboxNivel.' + parent).prop("checked", true);

			//remove a marcação do nível quando não tem nenhuma area selecionada
			let nivelElements = $('.' + parent);
			let totalChilds = nivelElements.length;
			let totalChildsUnChecked = nivelElements.length;

			for (var i = 0; i < totalChilds; i++) {
				if (!$(nivelElements[i]).prop("checked"))
					totalChildsUnChecked--;
			}

			if (totalChildsUnChecked == 1)
				$('.checkboxNivel.' + parent).prop("checked", false);

		});

	</script>

@endsection
