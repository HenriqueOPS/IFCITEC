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
                        Tarefas (Voluntários)
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
                <li class="active">
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
                        <div id="7">
                        <ul class="tab-comissao nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                            <li class="active">
                                <a id="avaliador" role="tab" data-toggle="tab">
                                    <i class="material-icons">assignment_ind</i>
                                    Avaliadores
                                </a>
                            </li>
                            <li>
                                <a id="homologador" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Homologadores
                                </a>
                            </li>
                        </ul>

                        <thead id="7">

                        <tr>
                            <th>Nome</th>
                            <th>Instituição</th>
                            <th>Titulação</th>
                            <th>Status</th>
                            <th></th>
                        </tr>

                        </thead>

                    </div>

                    <tbody id="7">

                    @foreach($comissao as $c)

                        @if($c->funcao_id == 4)
                            <tr class="homologador">
                        @else
                            <tr class="avaliador">
                        @endif

                            <td>{{$c->nome}}</td>
                            <td>{{$c->instituicao}}</td>
                            <td>{{$c->titulacao}}</td>
                            <td>
                                @if($c->homologado)
                                    <span class="label label-success">Homologado</span></td>
                                @else
                                    <span class="label label-warning">Não Homologado</span></td>
                                @endif
                            <td class="text-right">
                                <a href="{{route('homologarComissao',$c->id)}}"><i class="material-icons">visibility</i></a>
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

@section('js')

<script src="{{asset('js/main.js')}}"></script>
<script type="application/javascript">
$(document).ready(function () {

    //comissao avaliadora
    $('tr.homologador').hide();

    $('.tab-comissao #homologador').click(function (e) {
        $('tr.avaliador').hide();
        $('tr.homologador').show();
    });

    $('.tab-comissao #avaliador').click(function (e) {
        $('tr.avaliador').show();
        $('tr.homologador').hide();
    });


});


</script>

@endsection