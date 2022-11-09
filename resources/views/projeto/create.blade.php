@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-offset-1 col-xs-10">
                            <h2>Novo Projeto</h2>
                        </div>
                    </div>

                    <div class="row hide" id="loadCadastro">

                        <div class="loader loader--style2" title="1">
                            <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px"
                                height="80px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
                                xml:space="preserve">
                                <path fill="#000"
                                    d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
                                    <animateTransform attributeType="xml" attributeName="transform" type="rotate"
                                        from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite" />
                                </path>
                            </svg>
                        </div>

                    </div>

                    <div class="row hide" id="sucessoCadastro">
                        Projeto Cadastrado com Sucesso
                    </div>

                    <form method="post" id="cadastroProjeto" action="{{ route('projeto.store') }}">

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

                            <div class="col-md-10 col-md-offset-1 col-xs-11">
                                <div class="input-group{{ $errors->has('titulo') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">title</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Título</label>
                                        <input type="text" class="form-control" name="titulo"
                                            value="{{ old('titulo') }}" required style="text-transform: uppercase;">
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

                                        <select id="nivel-select" name="nivel"
                                            value="{{ old('nivel') ? old('nivel') : '' }}" required>
                                            <option></option>
                                            @foreach ($niveis as $nivel)
                                                @if ($nivel->id == old('nivel'))
                                                    <option id="nivel" selected="selected" value="{{ $nivel->id }}">
                                                        {{ $nivel->nivel }}</option>
                                                @else
                                                    <option id="nivel" value="{{ $nivel->id }}">{{ $nivel->nivel }}
                                                    </option>
                                                @endif
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
                                        <select id="area-select" name="area_conhecimento"
                                            value="{{ old('area_conhecimento') }}" required>
                                            <option></option>
                                        </select>

                                        @if ($errors->has('area_conhecimento'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('area_conhecimento') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <br>

                                <div class="col-md-offset-1 col-xs-offset-1">
                                    <p>Dica para os dois próximos tópicos:
                                        <a href="javascript:void(0);"
                                            class="atualizar btn btn-primary btn-fab btn-fab-mini btn-round" role="button">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                    </p>
                                </div>

                                <div class="input-group{{ $errors->has('resumo') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">format_align_justify</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Resumo</label>
                                        <textarea id="resumo" class="form-control" rows="5" name="resumo" required>{{ old('resumo') }}</textarea>
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
                                    <div class="alert alert-info text-center">
                                        <div class="container-fluid">
                                            <b>ATENÇÃO:</b> Para inserir as palavras-chave, tecle enter ao final de cada
                                            palavra!
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Palavras Chaves</label>
                                        <input type="text" id="palavras-chaves" name="palavras_chaves"
                                            value="{{ old('palavras_chaves') }}" required>
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
                                        <select id="escola-select" name="escola"
                                            value="{{ old('escola') ? old('escola') : '' }}" required>
                                            <option></option>
                                            @foreach ($escolas as $escola)
                                                @if (old('escola') == $escola->id)
                                                    <option value="{{ $escola->id }}" selected>
                                                        {{ $escola->nome_curto }}</option>
                                                @else
                                                    <option value="{{ $escola->id }}">{{ $escola->nome_curto }}
                                                    </option>
                                                @endif
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

                        <hr>
                        <div class="col-md-offset-1 col-xs-offset-1">
                            <p>Dica para os dois próximos tópicos:
                                <a href="javascript:void(0);" class="info btn btn-primary btn-fab btn-fab-mini btn-round"
                                    role="button">
                                    <i class="material-icons">visibility</i>
                                </a>
                            </p>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-offset-1">
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
                                            <select id="pessoa-1-select" name="autor[]"
                                                value="{{ old('autor')[0] ? old('autor')[0] : '' }}" required>
                                                <option></option>
                                                @foreach ($pessoas as $pessoa)
                                                    @if (old('autor')[0] == $pessoa->id)
                                                        <option value="{{ $pessoa->id }}" selected>{{ $pessoa->nome }}
                                                            < {{ $pessoa->email }}>
                                                        </option>
                                                    @else
                                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }} <
                                                                {{ $pessoa->email }}>
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="checkbox">
                                                <label>
                                                    <span style="margin-right: 5pt;">
                                                        Aluno concluinte?
                                                    </span>
                                                    <input type="hidden" name="autorConcluinte[0]" value=false>
                                                    <input type="checkbox" name="autorConcluinte[0]" value=true>
                                                </label>
                                            </div>
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
                                            <select id="pessoa-2-select" name="autor[]"
                                                value="{{ old('autor')[1] ? old('autor')[1] : '' }}">
                                                <option></option>
                                                @foreach ($pessoas as $pessoa)
                                                    @if (old('autor')[1] == $pessoa->id)
                                                        <option value="{{ $pessoa->id }}" selected>{{ $pessoa->nome }}
                                                            < {{ $pessoa->email }}>
                                                        </option>
                                                    @else
                                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }} <
                                                                {{ $pessoa->email }}>
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="checkbox">
                                                <label>
                                                    <span style="margin-right: 5pt;">
                                                        Aluno concluinte?
                                                    </span>
                                                    <input type="hidden" name="autorConcluinte[1]" value=false>
                                                    <input type="checkbox" name="autorConcluinte[1]" value=true>
                                                </label>
                                            </div>
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
                                            <select id="pessoa-3-select" name="autor[]"
                                                value="{{ old('autor]')[2] ? old('autor')[0] : '' }}">
                                                <option></option>
                                                @foreach ($pessoas as $pessoa)
                                                    @if (old('autor')[0] == $pessoa->id)
                                                        <option value="{{ $pessoa->id }}" selected>{{ $pessoa->nome }}
                                                            < {{ $pessoa->email }}>
                                                        </option>
                                                    @else
                                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }} <
                                                                {{ $pessoa->email }}>
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="checkbox">
                                                <label>
                                                    <span style="margin-right: 5pt;">
                                                        Aluno concluinte?
                                                    </span>
                                                    <input type="hidden" name="autorConcluinte[2]" value=false>
                                                    <input type="checkbox" name="autorConcluinte[2]" value=true>
                                                </label>
                                            </div>
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
                            <div class="col-md-10 col-md-offset-1 col-xs-offset-1">
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
                                            <select id="pessoa-4-select" name="orientador"
                                                value="{{ old('orientador') ? old('orientador') : '' }}" required>
                                                <option></option>
                                                @foreach ($pessoas as $pessoa)
                                                    @if (old('orientador') == $pessoa->id)
                                                        <option value="{{ $pessoa->id }}" selected>{{ $pessoa->nome }}
                                                            < {{ $pessoa->email }}>
                                                        </option>
                                                    @else
                                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }} <
                                                                {{ $pessoa->email }}>
                                                        </option>
                                                    @endif
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
                            <div class="col-md-10 col-md-offset-1 col-xs-offset-1">
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
                                            <select id="pessoa-5-select" name="coorientador[]"
                                                value="{{ old('coorientador')[0] ? old('coorientador')[0] : '' }}">
                                                <option></option>
                                                @foreach ($pessoas as $pessoa)
                                                    @if (old('coorientador')[0] == $pessoa->id)
                                                        <option value="{{ $pessoa->id }}" selected>{{ $pessoa->nome }}
                                                            < {{ $pessoa->email }}>
                                                        </option>
                                                    @else
                                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }} <
                                                                {{ $pessoa->email }}>
                                                        </option>
                                                    @endif
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
                                            <select id="pessoa-6-select" name="coorientador[]"
                                                value="{{ old('coorientador')[1] ? old('coorientador')[1] : '' }}">
                                                <option></option>
                                                @foreach ($pessoas as $pessoa)
                                                    @if (old('coorientador')[1] == $pessoa->id)
                                                        <option value="{{ $pessoa->id }}" selected>{{ $pessoa->nome }}
                                                            < {{ $pessoa->email }}>
                                                        </option>
                                                    @else
                                                        <option value="{{ $pessoa->id }}">{{ $pessoa->nome }} <
                                                                {{ $pessoa->email }}>
                                                        </option>
                                                    @endif
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

    <!-- Modal Info -->
    <div id="ModalInfo" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalInfo">
        <div class="modal-dialog3" role="document3">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Info</h5>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <p>Todos os participantes devem estar cadastrados no sistema para a vinculação abaixo. O projeto
                            deve conter no mínimo um autor e um orientador, como previsto no regulamento.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Modal Info -->

    <!-- Modal Nível -->
    <div id="ModalNivel" class="modal fade bd-example-modal-lg" role="dialog2" aria-labelledby="ModalNivel">
        <div class="modal-dialog" role="document2">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nivelModal"></h5>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <p>Segundo o regulamento, um projeto desse nível deve ter um resumo com no mínimo <a
                                id="min_chModal"></a> caracteres e no máximo <a id="max_chModal"></a> caracteres, e também
                            deve conter no mínimo <a id="palavrasModal"></a> palavras-chave.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Modal Nível -->
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/selectize.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.atualizar').click(function() {
                var nivel = $('#nivel-select').val();
                var urlConsulta = '.././projeto/nivel/dados-nivel/' + nivel;
                $.get(urlConsulta, function(res) {
                    $("#nivelModal").html(res.nivel);
                    $("#min_chModal").html(res.min_ch);
                    $("#max_chModal").html(res.max_ch);

                    window.document.getElementById("resumo").setAttribute("minlength", res.min_ch);
                    window.document.getElementById("resumo").setAttribute("maxlength", res.max_ch);

                    $("#palavrasModal").html(res.palavras);

                    $("#ModalNivel").modal();
                });

            });

            $('.info').click(function() {

                $("#ModalInfo").modal();
            });


            let frm = $('#cadastroProjeto');

            frm.submit(function(event) {

                $('#loadCadastro').removeClass('hide');

            });


            $('#resumo').keyup(function() {
                $('#total-char').html($('#resumo').val().length);
            });

            $('#palavras-chaves').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input.replace(/[^\w\-]+/g, ''),
                        text: input.replace(/[^\w\-]+/g, '')
                    }
                },
                onInitialize: function() {
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
                render: {
                    option_create: function(data, escape) {
                        return '<div class="create option">Inserir <strong>' + escape(data.input) +
                            '</strong>&hellip;</div>';
                    }
                },
            });

            var oldFuncao = $('#funcao-select').attr("value");
            $('#funcao-select').selectize({
                placeholder: 'Função...',
                render: {
                    option: function(item, escape) {
                        console.log(item);
                        return '<div class="option">Sou ' + escape(item.text) + '</div>';
                    }
                },
                onInitialize: function() {
                    this.setValue(oldFuncao, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldEscola = $('#escola-select').attr("value");
            $('#escola-select').selectize({
                placeholder: 'Digite a escola do projeto...',
                onInitialize: function() {
                    this.setValue(oldEscola, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldPessoa = $('#pessoa-1-select').attr("value");
            $('#pessoa-1-select').selectize({
                placeholder: 'Digite o nome do participante...',
                onInitialize: function() {
                    this.setValue(oldPessoa, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldPessoa = $('#pessoa-2-select').attr("value");
            $('#pessoa-2-select').selectize({
                placeholder: 'Digite o nome do participante...',
                onInitialize: function() {
                    this.setValue(oldPessoa, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldPessoa = $('#pessoa-3-select').attr("value");
            $('#pessoa-3-select').selectize({
                placeholder: 'Digite o nome do participante...',
                onInitialize: function() {
                    this.setValue(oldPessoa, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldPessoa = $('#pessoa-4-select').attr("value");
            $('#pessoa-4-select').selectize({
                placeholder: 'Digite o nome do participante...',
                onInitialize: function() {
                    this.setValue(oldPessoa, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldPessoa = $('#pessoa-5-select').attr("value");
            $('#pessoa-5-select').selectize({
                placeholder: 'Digite o nome do participante...',
                onInitialize: function() {
                    this.setValue(oldPessoa, true);
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
            });

            var oldPessoa = $('#pessoa-6-select').attr("value");
            $('#pessoa-6-select').selectize({
                placeholder: 'Digite o nome do participante...',
                onInitialize: function() {
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
                onInitialize: function() {
                    //$('.selectize-control').addClass('form-group');
                    $('.selectize-input').addClass('form-control');
                },
                onLoad: function(data) {
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
                onInitialize: function() {
                    this.setValue(oldNivel, false);
                    $('.selectize-input').addClass('form-control');
                },
                onChange: function(value) {
                    if (!value.length)
                        return;
                    areaSelect.disable();
                    areaSelect.clearOptions();
                    areaSelect.load(function(callback) {
                        realizaAjax(callback, value);
                    });
                }
            });

            nivelSelect = $nivelSelect[0].selectize;

            function realizaAjax(callback, value) {
                xhr && xhr.abort();
                xhr = $.ajax({
                    url: './nivel/areasConhecimento/' + value,
                    success: function(results) {
                        console.log(results);
                        areaSelect.enable(results);
                        callback(results);
                    },
                    error: function(xhr, textStatus) {
                        callback();
                    }
                });
            }

        });
    </script>
@endsection
