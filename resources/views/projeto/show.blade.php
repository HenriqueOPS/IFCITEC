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
                            <p class="resumo">{{$projeto->resumo}}</p>
                            <hr>
                            <b>Palavras-Chaves:</b> 
                            @foreach($projeto->palavrasChaves as $palavra)
                                {{$palavra->palavra}};
                            @endforeach
                            @if($projeto->revisoes->isNotEmpty())
                                @if ($projeto->getStatus() == "Reprovado")
                                    <hr>
                                    <b>Comentário da Homologação:</b><br>
                                    {{($projeto->revisoes[0]->observacao)}}
                                @endif
                            @endif
                        </div>
                        <div class="col-md-3">
                            @if(Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Revisor'))
                                @if($projeto->nivel->nivel == "Ensino Fundamental")
                                <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfCKdqjM1bo837QpS_yedl-NoLANx7A5sYUyKeCe9apVmSgpA/viewform?usp=pp_url&entry.750613590={{Auth::user()->nome}}&entry.120758124={{Auth::user()->email}}&entry.206285557={{Auth::user()->cpf}}&entry.1202356846={{$projeto->titulo}}&entry.1094928288={{$projeto->id}}&entry.1397554886" id="novo-integrante" class="btn btn-success">
                                    Avaliar
                                </a>
                                @else
                                <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScLFxQtDdtnOc2TMBPabNIRRlsk28AGMLOpeOrEDBmz0slg8g/viewform?usp=pp_url&entry.1142594772={{Auth::user()->nome}}&entry.1360361282={{Auth::user()->email}}&entry.1378712210={{Auth::user()->cpf}}&entry.2040078585={{$projeto->titulo}}&entry.1001736854={{$projeto->id}}&entry.529425973" id="novo-integrante" class="btn btn-success">
                                    Avaliar
                                </a>
                                @endif
                            @else
                                <a href="{{route('projeto.formVinculaIntegrante', ['projeto' => $projeto->id])}}" id="novo-integrante" class="btn btn-success">
                                    Novo Integrante
                                </a>
                            @endif

                            <br>
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



