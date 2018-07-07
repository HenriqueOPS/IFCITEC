@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Painel administrativo</h2>
        </div>

        <div id="page" class="col-md-10 col-xs-offset-2">
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
                <li>
                    <a href="dashboard" id="2" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">school</i>
                        Níveis
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="3" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">brightness_auto</i>
                        Áreas
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="4" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">list_alt</i>
                        Listar Projetos
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

                        @foreach($edicoes as $id => $edicao)

                        <tr>
                            <td class="text-center">{{$id+1}}</td>
                            <td>{{  \App\Edicao::numeroEdicao($edicao['ano']) }}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($edicao['inscricao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['inscricao_fechamento'])) }}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_fechamento'])) }}</td>
                            <td>{{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_fechamento'])) }}</td>
                            <td class="td-actions text-right">
                                <a href="javascript:void(0);" class="modalEdicao" id-edicao="{{ $edicao['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{route('editarEdicao',$edicao['id'])}}"><i class="material-icons">edit</i></a>
                                <a href="javascript:void(0);" class="excluirEdicao" id-edicao="{{ $edicao['id'] }}"><i class="material-icons blue-icon">delete</i></a>
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
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $escola['nome_curto'] }}</td>
                            <td></td>
                            <td>{{ $escola['email'] }}</td>
                            <td>{{ $escola['telefone'] }}</td>

                            <td class="td-actions text-right">
                                <a href="javascript:void(0);" class="modalEscola"  data-toggle="modal" data-target="#modal0" id-escola="{{ $escola['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{ route('escola', $escola['id']) }}"><i class="material-icons">edit</i></a>
                                <a href="javascript:void(0);" class="exclusao" id-escola="{{ $escola['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                    <thead id="2">
                    <div id="2">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroNivel') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Nível
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nível</th>
                        <th>Descrição</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="2">

                    @foreach($niveis as $i => $nivel)

                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $nivel['nivel'] }}</td>
                            <td>{{ $nivel['descricao'] }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalNivel" data-toggle="modal" data-target="#modal1" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('nivel', $nivel['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoNivel" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                    <thead id="3">
                    <div id="3">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroArea') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Área do Conhecimento
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Área do Conhecimento</th>
                        <th>Nível</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="3">

                    @foreach($niveis as $nivel)
                    @foreach($areas as $i => $area)
                    @if($area['nivel_id'] == $nivel['id'])
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $area['area_conhecimento'] }}</td>

                            <td>{{ $nivel['nivel'] }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalArea" data-toggle="modal" data-target="#modal2" id-area="{{ $area['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('area', $area['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoArea" id-area="{{ $area['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    @endforeach

                    </tbody>

                    <thead id="4">
                    <div id="4">

                    </div>

                    </thead>

                    <tbody id="4">
                        @foreach($projetos as $i => $projeto)

                        <div id="4" class="project">
                        <div class="project-title">
                             <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                        </div>
                        <div class="project-info">
                            Integrantes:
                            @foreach ($autores as $autor)
								@if($autor->projeto_id == $projeto->id)
								{{$autor->nome}},
								@endif
                            @endforeach

                            @foreach ($orientadores as $orientador)
								@if($orientador->projeto_id == $projeto->id)
								{{$orientador->nome}},
								@endif
                            @endforeach

                            @foreach($coorientadores as $coorientador)
								@if($coorientador->projeto_id == $projeto->id)
								{{$coorientador->nome}},
								@endif
                            @endforeach
                        </div>
                        </div>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('partials')

	@include('partials.modalEdicao')
	@include('partials.modalEscola')
	@include('partials.modalNivel')
	@include('partials.modalArea')

@endsection


@section('js')

<script src="{{asset('js/main.js')}}"></script>
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
    $('tbody[id=4]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
}
function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('thead[id=3]').hide();
    $('thead[id=4]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
}
</script>
@endsection

