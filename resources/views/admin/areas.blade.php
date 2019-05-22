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

            <div id="page" class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary"  role="tablist">
                <li>
                    <a href="{{route('administrador')}}">
                        <i class="material-icons">adjust</i>
                        Edições
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.escolas')}}">
                        <i class="material-icons">account_balance</i>
                        Escolas
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.niveis')}}">
                        <i class="material-icons">school</i>
                        Níveis
                    </a>
                </li>
                <li class="active">
                    <a href="{{route('administrador.areas')}}">
                        <i class="material-icons">brightness_auto</i>
                        Áreas
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.tarefas')}}">
                        <i class="material-icons">title</i>
                        Tarefas
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.usuarios')}}">
                        <i class="material-icons">person</i>
                        Usuários
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.projetos')}}">
                        <i class="material-icons">list_alt</i>
                        Listar Projetos
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.comissao')}}">
                        <i class="material-icons">list_alt</i>
                        Comissão Avaliadora
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.relatorios')}}">
                        <i class="material-icons">description</i>
                        Relatórios
                    </a>
                </li>
                <li>
                    <a href="{{route('gerFicha')}}">
                        <i class="material-icons">list_alt</i>
                        Fichas
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12 main main-raised">
            <div class="list-projects">
                    <table class="table">
                        <thead id="3">
                    <div id="3">
                        <div class="col-md-3 col-xs-3">
                            <a href="{{ route('cadastroArea') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Área
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
                    @foreach($areas as $id=>$area)
                        <tr>
                            <td class="text-center">{{ $id+1 }}</td>
                            <td>{{ $area['area_conhecimento'] }}</td>

                            <td>{{ $area->niveis()->first()->nivel }}</td>

                            <td class="td-actions text-right">
                                <a href="{{ route('areaProjetos', $area['id']) }}" target="_blank"><i class="material-icons">description</i></a>

                                <a href="javascript:void(0);" class="modalArea" data-toggle="modal" data-target="#modal2" id-area="{{ $area['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('area', $area['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoArea" id-area="{{ $area['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('partials')

    @include('partials.modalArea')

@endsection