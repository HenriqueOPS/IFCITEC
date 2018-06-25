@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Nível</h2>
                    </div>
                </div>
                <form name="f1" method="post" action="{{route('cadastroNivel')}}">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group{{ $errors->has('nivel') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome do Nível</label>
                                    <input type="text" class="form-control" name="nivel" required>
                                </div>
                                @if ($errors->has('nivel'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nivel') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('min_ch') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">remove_circle</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Caracteres mínimos para resumo</label>
                                    <input type="number" class="form-control" name="min_ch" required>
                                </div>
                                @if ($errors->has('min_ch'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('min_ch') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('max_ch') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">add_box</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Caracteres máximos para resumo</label>
                                    <input type="number" class="form-control" name="max_ch" min="min_ch" required>
                                </div>
                            @if ($errors->has('max_ch'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('max_ch') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('palavras') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">exposure_zero</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Número minímo de palavras-chave</label>
                                    <input type="number" class="form-control" name="palavras" min="palavras" required>
                                </div>
                                @if ($errors->has('palavras'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('palavras') }}</strong>
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

@endsection

