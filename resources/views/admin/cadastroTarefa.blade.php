@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">

@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Tarefa</h2>
                    </div>
                </div>
                <form method="post" action="{{ route('cadastroTarefa')}}">

                    {{ csrf_field() }}


                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group{{ $errors->has('tarefa') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome da Tarefa</label>
                                    <input type="text" class="form-control" name="tarefa" required>
                                </div>
                                @if ($errors->has('tarefa'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tarefa') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('vagas') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">exposure_zero</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Número de Vagas</label>
                                    <input type="number" class="form-control" name="vagas" required>
                                </div>
                                @if ($errors->has('vagas'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('vagas') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                                <div class="form-group label-floating">
                                    <i class="material-icons">description</i>
                                    <label for="exampleFormControlTextarea1">Descrição</label>
                                    <textarea class="form-control" rows="3" name="descricao" required></textarea>
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
                            <button class="btn btn-primary">Cadastrar</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection