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
                @foreach($funcoes as $funcao => $projetos)
                <span class="function">{{$funcao}}</span>
                    @foreach($projetos as $projeto)
                    <div class="project">
                        <div class="project-title">
                            <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                        </div>
                        <div class="project-info">
                            Integrantes: <span class="label label-info">Não Revisada</span>
                        </div>
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection