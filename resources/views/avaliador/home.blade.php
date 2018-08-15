@extends('layouts.app')


@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                <li>
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">adjust</i>
                        Não Revisados
                    </a>
                </li>
                <li class="active">
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons green-icon">done</i>
                        Homologados
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="3" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons red-icon">error</i>
                        Reprovados
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="5" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons blue-icon">done</i>
                        Avaliados
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="6" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">help</i>
                        Não Compareceram
                    </a>
                </li>
                <li>
                    <a href="" >Projetos Integrantes Agrupados</a>
                    <a href="" >Projetos Integrantes Não Agrupados</a>
                    <a href="" >Avaliadores</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-11 main main-raised"> 
            <div class="list-projects">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Integrantes</th>
                            <th>Título</th>
                            <th>Avaliadores</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                 

                        <tbody id="">
                      
                            <tr>
                                <td class="text-center"></td>
                                <td>
                                   
                                </td>
                                <td></td>
                                <td>
                                    
                                </td>
                                <td class="td-actions text-right">
                                    <a href=""><i class="material-icons blue-icon">remove_red_eye</i></a>
                                    <a href=""><i class="material-icons">assignment_ind</i></a>
                                    <a href="" class="setAvaliado"><i class="material-icons blue-icon">check_circle</i></a>
                                    <a href="" class="setNaoCompareceu"><i class="material-icons">help</i></a>
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
    $('tbody[id=1]').show();
    $('.tab').click(function (e) {
        var target = $(this)[0];
        hideBodys();
        $('tbody[id='+target.id+']').show();
    });

    $('.setAvaliado').bind('click',function(e) {
        e.preventDefault();
        var r = confirm("Definir projeto como avaliado?");
        if (r == true) {
            var target = $(this)[0];
            document.location.href = target.getAttribute('href');
        } else {

        }
    });

    $('.setNaoCompareceu').bind('click',function(e) {
        e.preventDefault();
        var r = confirm("Confirmar que projeto não compareceu?");
        if (r == true) {
            var target = $(this)[0];
            document.location.href = target.getAttribute('href');
        } else {

        }
    });
});

function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
    $('tbody[id=3]').hide();
    $('tbody[id=5]').hide();
    $('tbody[id=6]').hide();
}
</script>
@endsection
