@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Painel do Usuário</h2>
        </div>

        <div id="page" class="col-md-10 col-xs-offset-2">
            <ul class="nav nav-pills nav-pills-primary"  role="tablist">
                <li class="active">
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">person</i>
                        Autor
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">person</i>
                        Orientador
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="2" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">person</i>
                        Coorientador
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
            <table class="table">
                <thead id="0">
                <div id="0">
                    <div class="col-md-12">
                        <a  href="{{route('projeto.create')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">add</i> Novo Projeto
                        </a>

                        <a href="{{route('comissaoAvaliadora')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">assignment</i> Quero Ser Avaliador/ Revisor
                        </a>

                        <a href="{{route('voluntario')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">directions_walk</i> Quero Ser Voluntário
                        </a>
                    </div>
                </div>
        </div>
        </thead>
        <tbody id="0">
        <div id="0" class="list-projects">
            @if($funcoes->isEmpty())
            <div class="text-center">
                @if (!Auth::user()->temFuncao("Avaliador") && !Auth::user()->temFuncao("Revisor"))
                <span class="function">Você não possui nenhum projeto</span><br>
                @if(false)
                <a href="{{route('projeto.create')}}" class="btn btn-success">
                    Novo Projeto
                </a>
                @endif
                @else
                <span class="function">Você não possui nenhum projeto para homologar/revisar</span><br>
                @endif
            </div>
            @else
            @foreach($projetos as $projeto)
            @foreach ($autor as $dadosAutor)
            @if($dadosAutor->projeto_id == $projeto->id)
            @if(Auth::user()->id == $dadosAutor->id)
            <div class="project">
                <div class="project-title">
                    <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                </div>
                <div class="project-info">
                    Integrantes: 
                    
                    @foreach ($autor as $dadosAutor)
                    @if($dadosAutor->projeto_id == $projeto->id)
                    {{$dadosAutor->nome}},
                    @endif
                    @endforeach
                    
                    @foreach ($orientador as $dadosOrientador)
                    @if($dadosOrientador->projeto_id == $projeto->id)
                    {{$dadosOrientador->nome}},
                    @endif
                    @endforeach
                    

                    @foreach($coorientador as $dadosCoorientador)
                    @if($dadosCoorientador->projeto_id == $projeto->id)
                    {{$dadosCoorientador->nome}},
                    @endif
                    @endforeach
                </div>
            </div>

            @endif
            @endif
            @endforeach
            @endforeach
            @endif
        </div>
        </tbody>
        <thead id="1">
        <div id="1">
            <div class="col-md-12">
                        <a  href="{{route('projeto.create')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">add</i> Novo Projeto
                        </a>

                        <a href="{{route('comissaoAvaliadora')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">assignment</i> Quero Ser Avaliador/ Revisor
                        </a>

                        <a href="{{route('voluntario')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">directions_walk</i> Quero Ser Voluntário
                        </a>
                    </div>
            </div>
        </thead>
        <tbody id="1">
        <div id="1" class="list-projects">
            @if($funcoes->isEmpty())
            <div class="text-center">
                @if (!Auth::user()->temFuncao("Avaliador") && !Auth::user()->temFuncao("Revisor"))
                <span class="function">Você não possui nenhum projeto</span><br>
                @if(false)
                <a href="{{route('projeto.create')}}" class="btn btn-success">
                    Novo Projeto
                </a>
                @endif
                @else
                <span class="function">Você não possui nenhum projeto para homologar/revisar</span><br>
                @endif
            </div>
            @else

            @foreach($projetos as $projeto)
            @foreach ($orientador as $dadosOrientador)
            @if($dadosOrientador->projeto_id == $projeto->id)
            @if(Auth::user()->id == $dadosOrientador->id)
            <div class="project">
                <div class="project-title">
                    <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                </div>
                <div class="project-info">
                    Integrantes: 
                    @foreach ($autor as $dadosAutor)
                    @if($dadosAutor->projeto_id == $projeto->id)
                    {{$dadosAutor->nome}},
                    @endif
                    @endforeach
                    
                    @foreach ($orientador as $dadosOrientador)
                    @if($dadosOrientador->projeto_id == $projeto->id)
                    {{$dadosOrientador->nome}},
                    @endif
                    @endforeach
                    

                    @foreach($coorientador as $dadosCoorientador)
                    @if($dadosCoorientador->projeto_id == $projeto->id)
                    {{$dadosCoorientador->nome}},
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @endif
            @endforeach
            @endforeach

            @endif
        </div>
        </tbody>
        <thead id="2">
        <div id="2">
            <div class="col-md-12">
                        <a  href="{{route('projeto.create')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">add</i> Novo Projeto
                        </a>

                        <a href="{{route('comissaoAvaliadora')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">assignment</i> Quero Ser Avaliador/ Revisor
                        </a>

                        <a href="{{route('voluntario')}}" class="btn btn-primary btn-round">
                            <i class="material-icons">directions_walk</i> Quero Ser Voluntário
                        </a>
                    </div>
            </div>
        </thead>
        <tbody id="2">
        <div id="2" class="list-projects">
            @if($funcoes->isEmpty())
            <div class="text-center">
                @if (!Auth::user()->temFuncao("Avaliador") && !Auth::user()->temFuncao("Revisor"))
                <span class="function">Você não possui nenhum projeto</span><br>
                @if(false)
                <a href="{{route('projeto.create')}}" class="btn btn-success">
                    Novo Projeto
                </a>
                @endif
                @else
                <span class="function">Você não possui nenhum projeto para homologar/revisar</span><br>
                @endif
            </div>
            @else

            @foreach($projetos as $projeto)
            @foreach ($coorientador as $dadosCoorientador)
            @if($dadosCoorientador->projeto_id == $projeto->id)
            @if(Auth::user()->id == $dadosCoorientador->id)
            <div class="project">
                <div class="project-title">
                    <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                </div>
                <div class="project-info">
                    Integrantes: 
                    @foreach ($autor as $dadosAutor)
                    @if($dadosAutor->projeto_id == $projeto->id)
                    {{$dadosAutor->nome}},
                    @endif
                    @endforeach
                    
                    @foreach ($orientador as $dadosOrientador)
                    @if($dadosOrientador->projeto_id == $projeto->id)
                    {{$dadosOrientador->nome}},
                    @endif
                    @endforeach
                    

                    @foreach($coorientador as $dadosCoorientador)
                    @if($dadosCoorientador->projeto_id == $projeto->id)
                    {{$dadosCoorientador->nome}},
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @endif
            @endforeach
            @endforeach
            @endif
        </div>
        </tbody>
        </table>
    </div>


</div>
</div>
@endsection
@section('js')
<script type="application/javascript">
    $(document).ready(function () {


    hideHeads();
    hideBodys();
    $('thead[id=0]').show();
    $('tbody[id=0]').show();
    $('div[id=0]').show();
    $('.tab').click(function (e) {
    var target = $(this)[0];
    hideHeads();
    hideBodys(); 
    $('thead[id='+target.id+']').show();
    $('tbody[id='+target.id+']').show();
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