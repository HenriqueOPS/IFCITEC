@extends('layouts.app')

@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Edição IV</h2>
        </div>

        <div class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                <li class="active">
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">adjust</i>
                        Projetos
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons green-icon">done</i>
                        Áreas
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="2" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons red-icon">error</i>
                        Níveis
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12 main main-raised"> 
            <div class="list-projects">
                <table class="table">

                    <thead id="0">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Integrantes</th>
                        <th>Título</th>
                        <th>Avaliadores</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>


                    <tbody id="0">

                        <tr>
                            <td class="text-center">0</td>
                            <td>Érico Kemper, Eu</td>
                            <td>Projeto só pra ganhar nota em física</td>
                            <td>Fulano, Ciclano</td>
                            <td class="td-actions text-right">
                                <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="#"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                    </tbody>

                    <thead id="1">
                    <div id="1">
                        <div class="col-md-3">
                            <a href="cadastroArea" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Áreas
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Área</th>
                        <th>Nível</th>
                        <th>N. de Projetos</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="1">

                        <tr>
                            <td class="text-center">0</td>
                            <td>Ciências da terra e da natureza</td>
                            <td>Fundamental</td>
                            <td>10</td>
                            <td class="td-actions text-right">
                                <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="#"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                    </tbody>

                    <thead id="2">
                    <div id="2">
                        <div class="col-md-3">
                            <a href="cadastroNivel" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Níveis
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nível</th>
                        <th>N. de Áreas</th>
                        <th>N. de Projetos</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="2">

                        <tr>
                            <td class="text-center">0</td>
                            <td>Ciências da terra e da natureza</td>
                            <td>5</td>
                            <td>10</td>
                            <td class="td-actions text-right">
                                <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="#"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                    </tbody>


                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="application/javascript">
    $(document).ready(function () {
    hideBodys();
    hideHeads();
    $('tbody[id=0]').show();
    $('thead[id=0]').show();
    $('div[id=0]').show();
    $('.tab').click(function (e) {
    var target = $(this)[0];
    hideBodys();
    hideHeads();
    $('tbody[id='+target.id+']').show();
    $('thead[id='+target.id+']').show();
    $('div[id='+target.id+']').show();
    });


    });

    function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
    $('tbody[id=2]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    }
    function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    }
</script>
@endsection

