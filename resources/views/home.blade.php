@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3" >
            @if (!Auth::user()->temFuncao("Avaliador"))
                    <a href="{{route('projeto.create')}}" class="btn btn-success">
                        Novo Projeto
                    </a>
            @endif
        </div>
        <div class="col-md-9 main main-raised">
            <div class="list-projects">
                @if($funcoes->isEmpty())
                <div class="text-center">
                    @if (!Auth::user()->temFuncao("Avaliador"))
                    <span class="function">Você não possui nenhum projeto</span><br>
                    <a href="{{route('projeto.create')}}" class="btn btn-success">
                        Novo Projeto
                    </a>
                    @else
                     <span class="function">Você não possui nenhum projeto para homologar/revisar</span><br>
                    @endif
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