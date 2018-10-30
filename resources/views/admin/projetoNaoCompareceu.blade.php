@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Adicionar Projeto Não Compareceu</h2>
                    </div>
                </div>
                <form name="f1" method="post" action="{{route('naoCompareceu')}}">

                    {{ csrf_field() }}

                        <div class="col-md-12">
                            <div class="input-group{{ $errors->has('projeto') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Projetos</label>
                                    <select id="projeto-select" name="projeto" value="{{old('projeto') ? old('edicao'): ''}}" required>
                                        <option></option>
                                        @foreach ($projetos as $projeto)
                                            @if ($projeto->id == old('projeto'))
                                                <option selected="selected" value="{{$projeto->id}}">{{$projeto->titulo}}</option>
                                            @else
                                                <option value="{{$projeto->id}}">{{$projeto->titulo}}</option>
                                                
                                            @endif
                                        @endforeach
                                    </select>

                                    @if ($errors->has('projeto'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('projeto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                           
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Enviar</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="application/javascript">
$(document).ready(function () {

    var oldProjeto = $('#projeto-select').attr("value");
    $('#projeto-select').selectize({
        placeholder: 'Escolha um projeto...',
        onInitialize: function () {
            this.setValue(oldProjeto, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });
});
</script>

@endsection
