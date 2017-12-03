@extends('layouts.app')

@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>Painel administrativo</h2>
        </div>

        <div class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                <li class="active">
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">adjust</i>
                        Edições
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons green-icon">done</i>
                        Escolas
                    </a>
                </li>
                <li>
                    <a href="./administrador/cadastro/edicao" >Cadastrar edição</a>
                    <a href="/administrador/cadastro/escola" >Cadastrar escola</a>
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
                    <thead id="0">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Ano</th>
                            <th>Período de Inscrição</th>
                            <th>Período de Homologação</th>
                            <th>Período de Avaliação</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    

                        <tbody id="0">
                        
                            <tr>
                                <td class="text-center">0</td>
                                <td>IV</td>
                                <td>2017-05-05 21:00 - 2017-06-06 00:00</td>
                                <td>2017-05-05 21:00 - 2017-06-06 00:00</td>
                                <td>2017-05-05 21:00 - 2017-06-06 00:00</td>
                                <td class="td-actions text-right">
                                    <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                    <a href="#"><i class="material-icons">assignment_ind</i></a>
                                    <a href="#" class="setAvaliado"><i class="material-icons blue-icon">check_circle</i></a>
                                    <a href="#" class="setNaoCompareceu"><i class="material-icons">help</i></a>
                                </td>
                            <tr>

                            <tr>
                                <td class="text-center">0</td>
                                <td>V</td>
                                <td>2017-05-05 21:00 - 2017-06-06 00:00</td>
                                <td>2017-05-05 21:00 - 2017-06-06 00:00</td>
                                <td>2017-05-05 21:00 - 2017-06-06 00:00</td>
                                <td class="td-actions text-right">
                                    <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                    <a href="#"><i class="material-icons">assignment_ind</i></a>
                                    <a href="#" class="setAvaliado"><i class="material-icons blue-icon">check_circle</i></a>
                                    <a href="#" class="setNaoCompareceu"><i class="material-icons">help</i></a>
                                </td>
                            <tr>

                        </tbody>


                    <thead id="1">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Escola</th>
                            <th>Município</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>


                        <tbody id="1">
                        
                            <tr>
                                <td class="text-center">0</td>
                                <td>IFRS</td>
                                <td>Canoas</td>
                                <td>contato@canoas.ifrs.edu.br</td>
                                <td>(51) 3051-1234</td>
                                <td class="td-actions text-right">
                                    <a href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                    <a href="#"><i class="material-icons">assignment_ind</i></a>
                                    <a href="#" class="setAvaliado"><i class="material-icons blue-icon">check_circle</i></a>
                                    <a href="#" class="setNaoCompareceu"><i class="material-icons">help</i></a>
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
    $('.tab').click(function (e) {
        var target = $(this)[0];
        hideBodys();
        hideHeads();
        $('tbody[id='+target.id+']').show();
        $('thead[id='+target.id+']').show();
    });

});

function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
}
function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
}
</script>
@endsection

