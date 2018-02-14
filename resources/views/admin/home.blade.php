@extends('layouts.app')

@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Painel administrativo</h2>
        </div>

        <div class="col-md-3" >
            <ul class="nav nav-pills nav-pills-primary"  role="tablist">
                <li class="active">
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">adjust</i>
                        Edições
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">account_balance</i>
                        Escolas
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
                    <div id="0">
                        <div class="col-md-12">
                            <a href="{{ route('cadastroEdicao') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Edição
                            </a>
                        </div>
                    </div>
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

                        @foreach($edicoes as $edicao)

                        <tr>
                            <td class="text-center">0</td>
                            <td>{{$edicao->ano}}</td>
                            <td>{{$edicao->inscricao_abertura}} - {{$edicao->inscricao_fechamento}}</td>
                            <td>{{$edicao->homologacao_abertura}} - {{$edicao->homologacao_fechamento}}</td>
                            <td>{{$edicao->avaliacao_abertura}} - {{$edicao->avaliacao_fechamento}}</td>
                            <td class="td-actions text-right">
                                <a href="{{route( 'edicao',$edicao->id) }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="#{{$edicao->id}}"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                        @endforeach

                    </tbody>

                    <thead id="1">
                    <div id="1">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroEscola') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Escola
                            </a>
                        </div>
                    </div>
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

                    @foreach($escolas as $i => $escola)

                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $escola->nome_curto }}</td>
                            <td>MUNICIPIO</td>
                            <td>{{ $escola->email }}</td>
                            <td>{{ $escola->telefone }}</td>
                            <td class="td-actions text-right">
                                <a href="#escola-{{ $escola->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{ route('escola', $escola->id) }}"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                    @endforeach

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
    $('tbody[id=3]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    }
    function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('thead[id=3]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    }
</script>
@endsection

