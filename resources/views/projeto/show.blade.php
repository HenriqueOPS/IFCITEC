@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-7 col-md-offset-1">
                        <h2>{{$projeto->titulo}}</h2>
                    </div>
                </div>
                <div class="row">
                    <div id="projeto-show">
                        <div class="col-md-7 col-md-offset-1">
                            <div id="status">
                                <span class="label label-info">{{$projeto->getStatus()}}</span>
                            </div>
                            <p class="resumo">{{$projeto->resumo}}</p>
                            <hr>
                            <b>Palavras-Chaves:</b> 
                            @foreach($projeto->palavrasChaves as $palavra)
                                {{$palavra->palavra}};
                            @endforeach
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('projeto.formVinculaIntegrante', ['projeto' => $projeto->id])}}" id="novo-integrante" class="btn btn-success">
                                Novo Integrante
                            </a><br>
                            <b> <i class="material-icons">group</i> Integrantes:</b><br>

                            @foreach($projeto->pessoas as $pessoa)
                                <b>{{App\Funcao::find($pessoa->pivot->funcao_id)->funcao}}: </b>{{$pessoa->nome}}({{$pessoa->email}})<br>
                            @endforeach
                            <hr>
                            <b><i class="material-icons">school</i> Nível:</b><br>
                            {{$projeto->nivel->nivel}}
                            <hr>
                            <hr>
                            <b><i class="material-icons">school</i> Escola:</b><br>
                            {{App\Escola::find($projeto->pessoas[0]->pivot->escola_id)->nome_curto}}
                            <hr>
                            <b><i class="material-icons">public</i> Área do Conhecimento:</b><br>
                            {{$projeto->areaConhecimento->area_conhecimento}}
                            <hr>
                            <b><i class="material-icons">today</i> Submetido em:</b><br>
                            {{$projeto->created_at}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection



