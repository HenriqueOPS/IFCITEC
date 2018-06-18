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
                            <h3>Autor(es)</h3>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do Autor 1 (obrigatório):</span>
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
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalInt" data-toggle="modal" data-target="#modal" id-projeto="{{ $projeto->id }}" ><i class="material-icons blue-icon">remove_red_eye</i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do Autor 2 (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email2" class="form-control">
                                </div>
                            </div> 
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalInt2" data-toggle="modal" data-target="#modal" id-projeto="{{ $projeto->id }}" ><i class="material-icons blue-icon">remove_red_eye</i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-8 col-md-offset-1">
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do Autor 3 (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email3" class="form-control">
                                </div>
                            </div> 
                        </div>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                            <a class="modalInt3" data-toggle="modal" data-target="#modal" id-projeto="{{ $projeto->id }}" ><i class="material-icons blue-icon">remove_red_eye</i></a>
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
                        <div class="form-group">
                            <span id="projeto-show">Informe o email do Orientador (obrigatório):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email4" class="form-control">
                                </div>
                            </div> 
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
                            <span id="projeto-show">Informe o email do Coorientador (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email5" class="form-control">
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
                            <span id="projeto-show">Informe o email do Coorientador (opcional):</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" id="email6" class="form-control">
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
                    <div class="col-md-12 text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
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
@endsection

