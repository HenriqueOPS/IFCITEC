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
                <li class="active">
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
                    <a href="{{route('administrador.relatoriosEdicao')}}">
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
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                    <table class="table">
                <thead id="5">
                    <div id="5">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuários</th>
                            <th>E-mail</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </div>
                    </thead>

                    <tbody id="5">
                        @foreach($usuarios as $key=>$usuario)
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td>{{$usuario->nome}}</td>
                            <td>{{$usuario->email}}</td>
                            <td class="text-right">
                            <a href="{{route('editarUsuario',$usuario->id)}}"><i class="material-icons">edit</i></a>
                    
                            <a href="{{route('editarFuncaoUsuario',$usuario->id)}}"><i class="material-icons">star</i></a>
                        
                            <a href="javascript:void(0);" class="exclusaoUsuario" id-usuario="{{ $usuario['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                        
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

    @include('partials.modalUsuario')

@endsection
