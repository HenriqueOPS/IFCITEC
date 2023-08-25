<!-- Modal Tarefa -->
<div id="ModalCurso" class="modal fade bd-example-modal-lg"  aria-labelledby="Modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header" style="display:flex;justify-content:center;">
				<h2 class="modal-title">Cadastro de Curso</h2>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('admin.cursos.create')}}">
					{{ csrf_field() }}
					<div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group{{ $errors->has('curso') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome do Curso</label>
                                    <input type="text" class="form-control" name="nome" required>
                                </div>
                                @if ($errors->has('curso'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('curso') }}</strong>
                                </span>
                                @endif
                            </div>

                            <label for="fontSelect">Selecione a fonte:</label>
                        	<select id="fontSelect" name="nivel" required>
							@foreach($nivel as $nome)
								<option value="{{ $nome->id}}">{{$nome->nivel}}</option>
							@endforeach
							</select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Cadastrar</button>

                        </div>
                    </div>
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>
<!-- Fim Modal Tarefa -->
