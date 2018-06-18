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

                <form method="post" action="{{route('editaProjeto')}}">

                    {{ csrf_field() }}

                    <input type="hidden" name="id_projeto" value="{{ $projetoP->id }}">

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
                                    <input type="text" class="form-control" name="titulo" value="{{isset($projetoP->titulo) ? $projetoP->titulo : ''}}" required>
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
                                    <select id="nivel-select" name="nivel" value="{{isset($nivelP->id) ? $nivelP->id : ''}}" required>
                                        <option></option>
                                        @foreach ($niveis as $nivel)
                                        @if ($nivel->id == $nivelP->id)
                                        <option selected="selected" value="{{$nivel->id}}">{{$nivel->nivel}}</option>
                                        @else
                                        <option value="{{$nivel->id}}">{{$nivel->nivel}}</option>
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
                                    <select id="area-select" name="area_conhecimento" value="{{isset($areaP->id) ? $areaP->id : ''}}" required>
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
                                    <textarea id="resumo" class="form-control" rows="5" name="resumo" required>{{$projetoP->resumo}}</textarea>
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
                                    <input type="text" id="palavra-select" name="palavras_chaves" value="
                                    @foreach ($palavrasP as $key)
                                        {{ $key->palavra }}
                                        @if (next($palavrasP))
                                        ,
                                        @endif
                                    @endforeach
                                    " required>
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
                                    <select id="escola-select" name="escola" value="{{isset($escolaP->first()->escola_id) ? $escolaP->first()->escola_id : ''}}" required>
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
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group{{ $errors->has('autor[]') ? ' has-error' : '' }}">
                            <span id="projeto-show">Informe o email do Autor 1 (obrigatório):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email" class="form-control" name="autor[]" value="{{isset($autorP->get(0)->email) ? $autorP->get(0)->email : ''}}" required>
                                </div>
                                @if ($errors->has('autor[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('autor[]') }}</strong>
                                    </span>
                                @endif
                            </div> 
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalInt" data-toggle="modal" data-target="#modal" ><i class="material-icons blue-icon">remove_red_eye</i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group{{ $errors->has('autor[]') ? ' has-error' : '' }}">
                            <span>Informe o email do Autor 2 (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email2" class="form-control" name="autor[]" value="{{isset($autorP->get(1)->email) ? $autorP->get(1)->email : ''}}">
                                </div>
                                @if ($errors->has('autor[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('autor[]') }}</strong>
                                    </span>
                                @endif
                            </div>    
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalInt2" data-toggle="modal" data-target="#modal" ><i class="material-icons blue-icon">remove_red_eye</i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group{{ $errors->has('autor[]') ? ' has-error' : '' }}">
                            <span id="projeto-show">Informe o email do Autor 3 (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email3" class="form-control" name="autor[]" value="{{isset($autorP->get(2)->email) ? $autorP->get(2)->email : ''}}">
                                </div>
                            </div> 
                            @if ($errors->has('autor[]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('autor[]') }}</strong>
                                    </span>
                            @endif
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalInt3" data-toggle="modal" data-target="#modal" ><i class="material-icons blue-icon">remove_red_eye</i></a>
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
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group{{ $errors->has('orientador') ? ' has-error' : '' }}">
                            <span id="projeto-show">Informe o email do Orientador (obrigatório):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email4" class="form-control" name="orientador" value="{{isset($orientadorP->first()->email) ? $orientadorP->first()->email : ''}}" required>
                                </div>
                            </div> 
                            @if ($errors->has('orientador'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('orientador') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalOrt" data-toggle="modal" data-target="#modal"><i class="material-icons blue-icon">remove_red_eye</i></a>
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
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do Coorientador 1 (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email5" class="form-control" name="coorientador[]" value="{{isset($coorientadorP->get(0)->email) ? $coorientadorP->get(0)->email : ''}}">
                                </div>
                            </div> 
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalCoo1" data-toggle="modal" data-target="#modal"><i class="material-icons blue-icon">remove_red_eye</i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do Coorientador 2 (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email6" class="form-control" name="coorientador[]" value="{{isset($coorientadorP->get(1)->email) ? $coorientadorP->get(1)->email : ''}}">
                                </div>
                            </div> 
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalCoo2" data-toggle="modal" data-target="#modal"><i class="material-icons blue-icon">remove_red_eye</i></a>
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
<!-- Modal-->
<div id="modal" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Dados da Pessoa</h5>
        </div>
        <div class="modal-body">

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">person</i>
                </span>
                <div class="form-group label-floating">
                    <span id="nomeModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">email</i>
                </span>
                <div class="form-group label-floating">
                    <span id="emailModal"></span>
                </div>
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
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

<script type="application/javascript">
$('.modalInt').click(function(){
    email = $('#email').val();
    var urlConsulta = './vincula-integrante/'+email;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        if('error'){
        $("#nomeModal").html(res.error);
        $("#emailModal").html(null);
        console.log(urlConsulta);
        $("#modal").modal();
        }
        if('pessoa'){
        //altera o DOM
        $("#nomeModal").html(res.pessoa.nome);
        $("#emailModal").html(res.pessoa.email);
        //abre a modal
        $("#modal").modal();
         }
        

    });

})
</script>
<script type="application/javascript">
$('.modalInt2').click(function(){
    email = $('#email2').val();
    var urlConsulta = './vincula-integrante/'+email;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        if('error'){
        $("#nomeModal").html(res.error);
        $("#emailModal").html(null);
        console.log(res);
        $("#modal").modal();
        }
        if('pessoa'){
        //altera o DOM
        $("#nomeModal").html(res.pessoa.nome);
        $("#emailModal").html(res.pessoa.email);
        //abre a modal
        $("#modal").modal();
         }
        

    });

})
</script>
<script type="application/javascript">
$('.modalInt3').click(function(){
    email = $('#email3').val();
    var urlConsulta = './vincula-integrante/'+email;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        if('error'){
        $("#nomeModal").html(res.error);
        $("#emailModal").html(null);
        console.log(res);
        $("#modal").modal();
        }
        if('pessoa'){
        //altera o DOM
        $("#nomeModal").html(res.pessoa.nome);
        $("#emailModal").html(res.pessoa.email);
        //abre a modal
        $("#modal").modal();
         }
        

    });

})
</script>
<script type="application/javascript">
$('.modalOrt').click(function(){
    email = $('#email4').val();
    var urlConsulta = './vincula-integrante/'+email;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        if('error'){
        $("#nomeModal").html(res.error);
        $("#emailModal").html(null);
        console.log(res);
        $("#modal").modal();
        }
        if('pessoa'){
        //altera o DOM
        $("#nomeModal").html(res.pessoa.nome);
        $("#emailModal").html(res.pessoa.email);
        //abre a modal
        $("#modal").modal();
         }
        

    });

})
</script>
<script type="application/javascript">
$('.modalCoo1').click(function(){
    email = $('#email5').val();
    var urlConsulta = './vincula-integrante/'+email;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        if('error'){
        $("#nomeModal").html(res.error);
        $("#emailModal").html(null);
        console.log(res);
        $("#modal").modal();
        }
        if('pessoa'){
        //altera o DOM
        $("#nomeModal").html(res.pessoa.nome);
        $("#emailModal").html(res.pessoa.email);
        //abre a modal
        $("#modal").modal();
         }
        

    });

})
</script>
<script type="application/javascript">
$('.modalCoo2').click(function(){
    email = $('#email6').val();
    var urlConsulta = './vincula-integrante/'+email;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        if('error'){
        $("#nomeModal").html(res.error);
        $("#emailModal").html(null);
        console.log(res);
        $("#modal").modal();
        }
        if('pessoa'){
        //altera o DOM
        $("#nomeModal").html(res.pessoa.nome);
        $("#emailModal").html(res.pessoa.email);
        //abre a modal
        $("#modal").modal();
         }
        

    });

})
</script>
<script type="text/javascript">
$(document).ready(function () {

    $('#resumo').keyup(function () {
        $('#total-char').html($('#resumo').val().length);
    });

    //var oldPalavra = $('#palavra-select').attr("value");
    $('#palavra-select').selectize({
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
            //for(var chave=0, valor; valor=input[chave], chave<matriz.length; chave++) {
                 // chave é o índice, valor é o valor
            //}

            $('.selectize-input').addClass('form-control');
        },
        render: {
            option_create: function (data, escape) {
                return '<div class="create option">Inserir <strong>' + escape(data.input) + '</strong>&hellip;</div>';
            }
        },
    });

    var oldEscola = $('#escola-select').attr("value");
    $('#escola-select').selectize({
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