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
                <li class="active">
                    <a href="{{route('administrador.niveis')}}">
                        <i class="material-icons">school</i>
                        Níveis
                    </a>
                </li>
                <li>
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
                    <a href="{{route('administrador.notas')}}">
                        <i class="material-icons">note_add</i>
                        Notas
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.relatoriosEdicao')}}">
                        <i class="material-icons">description</i>
                        Relatórios
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
                                <a href="{{ route('nivelProjetos', $nivel['id']) }}" target="_blank"><i class="material-icons">description</i></a>

                                <a href="javascript:void(0);" class="modalNivel" data-toggle="modal" data-target="#modal1" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('nivel', $nivel['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoNivel" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        <tr>

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

    @include('partials.modalNivel')

@endsection
