@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 main main-raised">
            <div class="list-projects">
                {{ dd($funcoes['Avaliação']) }}
                @if($funcoes->isEmpty())
                <div class="text-center">
                     <span class="function">Você não possui nenhum projeto para homologar/revisar</span><br>
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
                                    @if($projeto->getStatus() == "Não Revisado")
                                        <span class="label label-info">{{$projeto->getStatus()}}</span>
                                    @elseif ($projeto->getStatus() == "Homologado")
                                        <span class="label label-success">{{$projeto->getStatus()}}</span>
                                    @elseif ($projeto->getStatus() == "Reprovado")
                                        <span class="label label-danger">{{$projeto->getStatus()}}</span>
                                    @else
                                        <span class="label label-default">{{$projeto->getStatus()}}</span>
                                    @endif
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
