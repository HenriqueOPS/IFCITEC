@extends('layouts.app')


@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                <li class="active">
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">adjust</i>
                        Não Revisados
                    </a>
                </li>
                <li>
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
                    <a href="{{route('relatorio',['id' => 1])}}" >Projetos Integrantes Agrupados</a>
                    <a href="{{route('relatorio',['id' => 2])}}" >Projetos Integrantes Não Agrupados</a>
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
                            <th>Revisor</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    @foreach($situacoes as $situacao=>$projetos)
                        <tbody id="{{$situacao}}">
                        @foreach($projetos as $projeto)
                            <tr>
                                <td class="text-center">{{$projeto->id}}</td>
                                <td>
                                    @foreach($projeto->pessoas as $pessoa)
                                        {{explode(" ", $pessoa->nome)[0]}}
                                    @endforeach
                                </td>
                                <td>{{$projeto->titulo}}</td>
                                <td>
                                    @if($projeto->revisoes->isNotEmpty())
                                        {{$projeto->revisoes[0]->pessoa->nome}}
                                    @endif
                                </td>
                                <td class="td-actions text-right">
                                    <a href="{{route('projeto.show', ['projeto' => $projeto->id])}}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                    <a href="{{route('vinculaAvaliador', ['id' => $projeto->id])}}"><i class="material-icons blue-icon">check_circle</i></a>
                                </td>
                            <tr>
                        @endforeach
                        </tbody>
                    @endforeach

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
    $('tbody[id=0]').show();
    $('.tab').click(function (e) {
        var target = $(this)[0];
        hideBodys();
        $('tbody[id='+target.id+']').show();
    });
});

function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
    $('tbody[id=3]').hide();
}
</script>
@endsection

