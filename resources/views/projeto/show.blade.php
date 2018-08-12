@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

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
                                @if($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Não Avaliado")
                                    <span class="label label-info">{{$projeto->getStatus()}}</span>
                                @elseif ($projeto->getStatus() == "Homologado" || $projeto->getStatus() == "Avaliado")
                                    <span class="label label-success">{{$projeto->getStatus()}}</span>
                                @elseif ($projeto->getStatus() == "Não Compareceu")
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
                            @if(Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Homologador'))

                                @if((\App\Edicao::consultaPeriodo('Homologação')))

                                    <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScwVSWWpbvwB6BKYk1Cz-SaObHgUrlMnkbiLxaBB3szdLmnZQ/viewform?usp=pp_url&entry.1051144494={{$projeto->titulo}}&entry.259386738={{$projeto->nivel->nivel}}&entry.1403982251={{$projeto->areaConhecimento->area_conhecimento}}&entry.1561957447={{$projeto->id}}&entry.276755517={{Auth::user()->nome}}&entry.846448634={{Auth::user()->id}}" id="novo-integrante" class="btn btn-success">
                                        Homologar
                                    </a>

                                @endif

                                <!--
                                @if((\App\Edicao::consultaPeriodo('Avaliação')))

                                    <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScLFxQtDdtnOc2TMBPabNIRRlsk28AGMLOpeOrEDBmz0slg8g/viewform?usp=pp_url&entry.1142594772={{Auth::user()->nome}}&entry.1360361282={{Auth::user()->email}}&entry.1378712210={{Auth::user()->cpf}}&entry.2040078585={{$projeto->titulo}}&entry.1001736854={{$projeto->id}}&entry.442913637={{$projeto->areaConhecimento->area_conhecimento}}&entry.529425973" id="novo-integrante" class="btn btn-success">
                                        Avaliar
                                    </a>

                                @endif

                                @if($projeto->getStatus() != "Avaliado")
                                    @if($projeto->nivel->nivel == "Ensino Fundamental")

                                    <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfCKdqjM1bo837QpS_yedl-NoLANx7A5sYUyKeCe9apVmSgpA/viewform?usp=pp_url&entry.750613590={{Auth::user()->nome}}&entry.120758124={{Auth::user()->email}}&entry.206285557={{Auth::user()->cpf}}&entry.1202356846={{$projeto->titulo}}&entry.1094928288={{$projeto->id}}&entry.1177766823={{$projeto->areaConhecimento->area_conhecimento}}&entry.1397554886" id="novo-integrante" class="btn btn-success">
                                        Avaliar
                                    </a>
                                    @else
                                    <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScLFxQtDdtnOc2TMBPabNIRRlsk28AGMLOpeOrEDBmz0slg8g/viewform?usp=pp_url&entry.1142594772={{Auth::user()->nome}}&entry.1360361282={{Auth::user()->email}}&entry.1378712210={{Auth::user()->cpf}}&entry.2040078585={{$projeto->titulo}}&entry.1001736854={{$projeto->id}}&entry.442913637={{$projeto->areaConhecimento->area_conhecimento}}&entry.529425973" id="novo-integrante" class="btn btn-success">
                                        Avaliar
                                    </a>
                                    @endif
                                @endif
                                -->

                            @else
                                <a href="{{ route('editarProjeto', $projeto->id) }}" class="btn btn-success">
                                    Editar informações
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
                            <b><i class="material-icons">school</i> Escola:</b><br>
                            {{App\Escola::find($projeto->pessoas[0]->pivot->escola_id)->nome_curto}}
                            <hr>
                            <b><i class="material-icons">public</i> Área do Conhecimento:</b><br>
                            {{$projeto->areaConhecimento->area_conhecimento}}
                            <hr>
                            <b><i class="material-icons">today</i> Submetido em:</b><br>
                            {{date('d/m/Y H:i:s', strtotime($projeto->created_at))}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
