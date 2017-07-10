@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h2>{{$projeto->titulo}}</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="dados-pessoa">
                    <form method="POST" action="{{route('projeto.vinculaIntegrante')}}">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <hr>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">face</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome</label>
                                        <input type="text" id="nome" name="nome" class="form-control" disabled>
                                    </div>
                                    @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('funcao') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">assignment_ind</i>
                                    </span>
                                    <div class="form-group">
                                        <label class="control-label">Função</label>
                                        <select id="funcao-select" name="funcao"required>
                                            <option></option>
                                            @foreach ($funcoes as $funcao)
                                            <option value="{{$funcao->id}}">{{$funcao->funcao}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="input-group{{ $errors->has('escola') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">school</i>
                                    </span>
                                    <div class="form-group">
                                        <label class="control-label">Escola</label>
                                        <select id="escola-select" name="escola" required>
                                            <option></option>
                                            @foreach ($escolas as $escola)
                                            <option value="{{$escola->id}}">{{$escola->nome_curto}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <input type="hidden" name="pessoa">
                                <input type="hidden" name="projeto" value="{{$projeto->id}}">
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">

                                    <input type="submit" class="btn btn-success" value="Submeter">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('#dados-pessoa').hide();
    $('#error').hide();
    $('#pesquisa-pessoa').click(function () {
        $('#dados-pessoa').hide();
        $('#error').hide();
        //
        var email = $('#email').val();
        var projeto = $("input[name='projeto']").val();
        $.get("http://localhost/ifcitec/public/projeto/" + projeto + "/vincula-integrante/" + email, function (data) {
            if (typeof data.error !== 'undefined') {
                $('#error-message').html(data.error);
                $('#error').show();
            } else {
                $('#nome').val(data.nome);
                $('#nome').trigger("change");
                $("input[name='pessoa']").val(data.id);
                $('#dados-pessoa').show();
            }
        });
    });



    $('#escola-select').selectize({
        placeholder: 'Digite a Escola...',
        onInitialize: function () {
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    $('#funcao-select').selectize({
        placeholder: 'Função...',
        render: {
            option: function (item, escape) {
                console.log(item);
                return '<div class="option">Ele é ' + escape(item.text) + '</div>';
            }
        },
        onInitialize: function () {
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });
});
</script>
@endsection


