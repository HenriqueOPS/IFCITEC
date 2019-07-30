@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Editar Área</h2>
                    </div>
                </div>
                <form method="post" action="{{ route('editaArea') }}">

                    {{ csrf_field() }}

                    <input type="hidden" name="id_area" value="{{ $dados->id }}">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group{{ $errors->has('nivel_id') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nível</label>
                                    <select id="nivel-select" name="nivel_id" id="nivel_id" value="{{isset($dados->nivel_id) ? $dados->nivel_id : ''}}" required>
										@foreach ($niveis as $nivel)

											@if($dados->nivel_id == $nivel->id)
												<option value="{{$nivel->id}}" selected>{{$nivel->nivel}}</option>
											@else
												<option value="{{$nivel->id}}">{{$nivel->nivel}}</option>
											@endif

										@endforeach
                                    </select>
                                </div>
                                @if ($errors->has('nivel_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nivel_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group{{ $errors->has('area_conhecimento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome da Área</label>
                                    <input type="text" class="form-control" name="area_conhecimento" value="{{isset($dados->area_conhecimento) ? $dados->area_conhecimento : ''}}" required>
                                </div>
                                @if ($errors->has('area_conhecimento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('area_conhecimento') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                                <div class="form-group label-floating">
                                    <i class="material-icons">description</i>
                                    <label for="exampleFormControlTextarea1">Descrição</label>
                                    <textarea class="form-control" rows="3" name="descricao" required>{{isset($dados->descricao) ? $dados->descricao : ''}}</textarea>
                                </div>
                                @if ($errors->has('descricao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('descricao') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
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
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {

    var xhr;
    var nivelSelect, $nivelSelect;

    var oldNivel = $('#nivel-select').attr("value");

    $nivelSelect = $('#nivel-select').selectize({
        placeholder: 'Escolha o Nível...',
        preload: true,
        onInitialize: function () {
            this.setValue(oldNivel, false);
            $('.selectize-input').addClass('form-control');
        },
    });
});

</script>
@endsection
