@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3" >
            <a href="{{route('projeto.create')}}" class="btn btn-success">
                Novo Projeto
            </a>
        </div>
        <div class="col-md-9 main main-raised">
            <div class="list-projects">
                @if($funcoes->isEmpty())
                <div class="text-center">
                    <span class="function">Você não possui nenhum projeto inscrito</span><br>
                    <a href="{{route('projeto.create')}}" class="btn btn-success">
                        Novo Projeto
                    </a>
                </div>
                @else
                    @foreach($funcoes as $funcao => $projetos)
                        <span class="function">{{$funcao}}</span>
                        @foreach($projetos as $projeto)
                        <div class="project">
                            <div class="project-title">
                                <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                            </div>
                            <div class="project-info">
                                Integrantes: 
                                @foreach($projeto->pessoas as $pessoa)
                                    {{explode(" ", $pessoa->nome)[0]}}. 
                                @endforeach
                                <span class="label label-info">{{$projeto->getStatus()}}</span>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>
@endsection