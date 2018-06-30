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
                    <div class="col-md-10 col-md-offset-1">
                        <h2>Novo Projeto</h2>
                    </div>
                </div>

                <form method="post" action="{{route('projeto.store')}}">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center">
                                <div class="container-fluid">
                                    <div class="alert-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                    </button>
                                    <b>ATENÇÃO: </b>É obrigatória a leitura do edital.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10 col-md-offset-1">
                            <div class="input-group{{ $errors->has('titulo') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">title</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Título</label>
                                    <input type="text" class="form-control" name="titulo" value="{{old('titulo')}}" required>
                                </div>
                                @if ($errors->has('titulo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('titulo') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('nivel') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Nível</label>
                                    <select id="nivel-select" name="nivel" required>
                                        <option></option>
                                        @foreach ($niveis as $nivel)
                                        <option value="{{$nivel->id}}">{{$nivel->nivel}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('nivel'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nivel') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-group{{ $errors->has('area_conhecimento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">public</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Área do Conhecimento</label>
                                    <select id="area-select" name="area_conhecimento" value="{{old('area_conhecimento')}}" required>
                                        <option></option>
                                    </select>

                                    @if ($errors->has('area_conhecimento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area_conhecimento') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="input-group{{ $errors->has('resumo') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">format_align_justify</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Resumo</label>
                                    <textarea id="resumo" class="form-control" rows="5" name="resumo" required>{{old('resumo')}}</textarea>
                                    <p>Total de Caracteres: <b><span id="total-char"></span></b></p>
                                </div>
                                @if ($errors->has('resumo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('resumo') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('palavras_chaves') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">format_quote</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Palavras Chaves</label>
                                    <input type="text" id="palavras-chaves" name="palavras_chaves" value="{{old('palavras_chaves')}}" required>
                                </div>
                                @if ($errors->has('palavras_chaves'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('palavras_chaves') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('escola') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Escola</label>
                                    <select id="escola-select" name="escola" value="{{old('escola')}}" required>
                                        <option></option>
                                        @foreach ($escolas as $escola)
                                        <option value="{{$escola->id}}">{{$escola->nome_curto}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('escola'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('escola') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Autor(es)</h3>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1">
                        <span id="projeto-show">Informe o email do Autor 1 (obrigatório):</span>
                        <div class="input-group{{ $errors->has('autor[]') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Autor 1</label>
                                    <select id="pessoa-1-select" name="autor[]" value="{{old('autor[0]')}}"  required>
                                        <option></option>
                                        @foreach ($pessoas as $pessoa)
                                        <option value="{{$pessoa->id}}">{{$pessoa->nome}} < {{$pessoa->email}} ></option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('autor[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('autor[]') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1">
                        <span id="projeto-show">Informe o email do Autor 2 (opcional):</span>
                        <div class="input-group{{ $errors->has('autor[]') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Autor 2</label>
                                    <select id="pessoa-2-select" name="autor[]">
                                        <option></option>
                                        @foreach ($pessoas as $pessoa)
                                        <option value="{{$pessoa->id}}">{{$pessoa->nome}} < {{$pessoa->email}} ></option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('autor[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('autor[]') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1">
                        <span id="projeto-show">Informe o email do Autor 3 (opcional):</span>
                        <div class="input-group{{ $errors->has('autor[]') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Autor 3</label>
                                    <select id="pessoa-3-select" name="autor[]">
                                        <option></option>
                                        @foreach ($pessoas as $pessoa)
                                        <option value="{{$pessoa->id}}">{{$pessoa->nome}} < {{$pessoa->email}} ></option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('autor[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('autor[]') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Orientador</h3>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1">
                        <span id="projeto-show">Informe o email do Orientador (obrigatório):</span>
                        <div class="input-group{{ $errors->has('orientador') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Orientador</label>
                                    <select id="pessoa-4-select" name="orientador" required>
                                        <option></option>
                                        @foreach ($pessoas as $pessoa)
                                        <option value="{{$pessoa->id}}">{{$pessoa->nome}} < {{$pessoa->email}} ></option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('orientador'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('orientador') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Coorientador(es)</h3>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1">
                        <span id="projeto-show">Informe o email do Coorientador 1 (opcional):</span>
                        <div class="input-group{{ $errors->has('coorientador[]') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Coorientador 1</label>
                                    <select id="pessoa-5-select" name="coorientador[]">
                                        <option></option>
                                        @foreach ($pessoas as $pessoa)
                                        <option value="{{$pessoa->id}}">{{$pessoa->nome}} < {{$pessoa->email}} ></option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('coorientador[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('coorientador[]') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-9 col-md-offset-1">
                        <span id="projeto-show">Informe o email do Coorientador (opcional):</span>
                        <div class="input-group{{ $errors->has('coorientador[]') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Coorientador 2</label>
                                    <select id="pessoa-6-select" name="coorientador[]">
                                        <option></option>
                                        @foreach ($pessoas as $pessoa)
                                        <option value="{{$pessoa->id}}">{{$pessoa->nome}} < {{$pessoa->email}} ></option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('coorientador[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('coorientador[]') }}</strong>
                                    </span>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                    
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Submeter Projeto</button>
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

    $('#resumo').keyup(function () {
        $('#total-char').html($('#resumo').val().length);
    });

    $('#palavras-chaves').selectize({
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            }
        },
        onInitialize: function () {
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
        render: {
            option_create: function (data, escape) {
                return '<div class="create option">Inserir <strong>' + escape(data.input) + '</strong>&hellip;</div>';
            }
        },
    });

    var oldFuncao = $('#funcao-select').attr("value");
    $('#funcao-select').selectize({
        placeholder: 'Função...',
        render: {
            option: function (item, escape) {
                console.log(item);
                return '<div class="option">Sou ' + escape(item.text) + '</div>';
            }
        },
        onInitialize: function () {
            this.setValue(oldFuncao, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldEscola = $('#escola-select').attr("value");
    $('#escola-select').selectize({
        placeholder: 'Digite a Escola a qual pertence o projeto...',
        onInitialize: function () {
            this.setValue(oldEscola, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldPessoa = $('#pessoa-1-select').attr("value");
    $('#pessoa-1-select').selectize({
        placeholder: 'Digite o nome do participante...',
        onInitialize: function () {
            this.setValue(oldPessoa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldPessoa = $('#pessoa-2-select').attr("value");
    $('#pessoa-2-select').selectize({
        placeholder: 'Digite o nome do participante...',
        onInitialize: function () {
            this.setValue(oldPessoa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldPessoa = $('#pessoa-3-select').attr("value");
    $('#pessoa-3-select').selectize({
        placeholder: 'Digite o nome do participante...',
        onInitialize: function () {
            this.setValue(oldPessoa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldPessoa = $('#pessoa-4-select').attr("value");
    $('#pessoa-4-select').selectize({
        placeholder: 'Digite o nome do participante...',
        onInitialize: function () {
            this.setValue(oldPessoa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldPessoa = $('#pessoa-5-select').attr("value");
    $('#pessoa-5-select').selectize({
        placeholder: 'Digite o nome do participante...',
        onInitialize: function () {
            this.setValue(oldPessoa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });

    var oldPessoa = $('#pessoa-6-select').attr("value");
    $('#pessoa-6-select').selectize({
        placeholder: 'Digite o nome do participante...',
        onInitialize: function () {
            this.setValue(oldPessoa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });


    var xhr;
    var nivelSelect, $nivelSelect;
    var areaSelect, $areaSelect;

    var oldArea = $('#area-select').attr("value"); 

     $areaSelect = $('#area-select').selectize({
        placeholder: 'Área do Conhecimento...',
        valueField: ['id'],
        labelField: ['area_conhecimento'],
        searchField: ['area_conhecimento'],
        onInitialize: function () {
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
        onLoad: function (data) {
            console.log(data);
            this.setValue(oldArea, false);
            oldArea = null;
        }
    });

    areaSelect = $areaSelect[0].selectize;
    areaSelect.disable();

    var oldNivel = $('#nivel-select').attr("value");

    $nivelSelect = $('#nivel-select').selectize({
        placeholder: 'Escolha o Nível...',
        preload: true,
        onInitialize: function () {
            this.setValue(oldNivel, false);
            $('.selectize-input').addClass('form-control');
        },
        onChange: function (value) {
            if (!value.length)
                return;
            areaSelect.disable();
            areaSelect.clearOptions();
            areaSelect.load(function (callback) {
                realizaAjax(callback, value);
            });
        }
    });

    nivelSelect = $nivelSelect[0].selectize;

    function realizaAjax(callback, value) {
        xhr && xhr.abort();
        xhr = $.ajax({
            url: './nivel/areasConhecimento/' + value,
            success: function (results) {
                console.log(results);
                areaSelect.enable(results);
                callback(results);
            },
            error: function (xhr, textStatus) {
                callback();
            }
        });
    }

});
</script>
@endsection
