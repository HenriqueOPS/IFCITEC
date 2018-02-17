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
                                    <b>ATENÇÃO: </b>É obrigatória a leitura do edital:
                                    <a href="http://ifcitec.canoas.ifrs.edu.br/wp-content/uploads/2017/06/Regulamento-V-IFCITEC-2017.pdf" target="_blank">
                                        <b>IFCITEC - Edital 2017</b>
                                    </a>
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

                            <div class="input-group{{ $errors->has('nivel') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Nível</label>
                                    <select id="nivel-select" name="nivel" value="{{old('nivel')}}" required>
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

                            <div class="input-group{{ $errors->has('area') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">public</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Área do Conhecimento</label>
                                    <select id="area-select" name="area" value="{{old('area')}}" required>
                                        <option></option>
                                    </select>

                                    @if ($errors->has('area'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h2>Vínculo</h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="input-group{{ $errors->has('funcao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">assignment_ind</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Função</label>
                                    <select id="funcao-select" name="funcao" value="{{old('funcao')}}" required>
                                        <option></option>
                                        @foreach ($funcoes as $funcao)
                                        <option value="{{$funcao->id}}">{{$funcao->funcao}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('funcao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('funcao') }}</strong>
                                    </span>
                                    @endif
                                </div>
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
        placeholder: 'Digite a Escola...',
        onInitialize: function () {
            this.setValue(oldEscola, true);
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
        valueField: 'id',
        labelField: 'area_conhecimento',
        searchField: 'area_conhecimento',
        onInitialize: function () {
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
        onLoad: function (data) {
            this.setValue(oldArea, false);
            oldArea = null;
        },
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
            url: 'nivel/areasConhecimento/' + value,
            success: function (results) {
                areaSelect.enable();
                console.log(results);
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