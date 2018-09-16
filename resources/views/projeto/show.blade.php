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

                            <hr>

                            @if(count($obsHomologadores) && (!(\App\Edicao::consultaPeriodo('Homologação')) || Auth::user()->temFuncao('Administrador')))
                                <h3>Homologação:</h3>
                                @foreach($obsHomologadores as $obs)
                                    <b>Observação do Homologador {{$loop->index + 1}}:</b><br>
                                    <p>{{$obs->observacao}}</p>

                                    <hr>
                                @endforeach
                            @endif

                            @if(count($obsAvaliadores) && (!(\App\Edicao::consultaPeriodo('Avaliação')) || Auth::user()->temFuncao('Administrador')))
                                <h3>Avaliação:</h3>
                                @foreach($obsAvaliadores as $obs)
                                    <b>Observação do Avaliador {{$loop->index + 1}}:</b><br>
                                    <p>{{$obs->observacao}}</p>

                                    <hr>
                                @endforeach
                            @endif

                        </div>

                        <div class="col-md-3">
                            @if(Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Homologador'))

                                @if((\App\Edicao::consultaPeriodo('Homologação')) && $ehHomologador)

                                    <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScwVSWWpbvwB6BKYk1Cz-SaObHgUrlMnkbiLxaBB3szdLmnZQ/viewform?usp=pp_url&entry.1051144494={{urlencode($projeto->titulo)}}&entry.259386738={{urlencode($projeto->nivel->nivel)}}&entry.1403982251={{urlencode($projeto->areaConhecimento->area_conhecimento)}}&entry.1561957447={{$projeto->id}}&entry.276755517={{urlencode(Auth::user()->nome)}}&entry.846448634={{Auth::user()->id}}" id="homologar-projeto" class="btn btn-success">
                                        Homologar
                                    </a>

                                @endif

                                @if((\App\Edicao::consultaPeriodo('Avaliação')) && $ehAvaliador)

                                    @if($projeto->getStatus() != "Avaliado")

                                        @if($projeto->nivel->nivel == "Ensino Fundamental")

                                        <!-- DEV -->
                                        <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSf-UK8CSnicU0_lUj5GRJnO51lbXLKazGKz4BeoqYuKayJP5Q/viewform?usp=pp_url&entry.1937205043={{urlencode($projeto->titulo)}}&entry.1262812210={{urlencode($projeto->nivel->nivel)}}&entry.2140598612={{urlencode($projeto->areaConhecimento->area_conhecimento)}}&entry.1274479363={{$projeto->id}}&entry.1888254598={{urlencode(Auth::user()->nome)}}&entry.2083262699={{Auth::user()->id}}" id="novo-integrante" class="btn btn-success">
                                            Avaliar
                                        </a>

                                        <!-- PRODUÇÃO
                                        <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScoHqGSMIyCde2zR4H3eogjLnjSO5h9gI_ZBbQElePQIgvcAA/viewform?usp=pp_url&entry.1937205043={{urlencode($projeto->titulo)}}&entry.1262812210={{urlencode($projeto->nivel->nivel)}}&entry.2140598612={{urlencode($projeto->areaConhecimento->area_conhecimento)}}&entry.1274479363={{$projeto->id}}&entry.1888254598={{urlencode(Auth::user()->nome)}}&entry.2083262699={{Auth::user()->id}}" id="novo-integrante" class="btn btn-success">
                                            Avaliar
                                        </a> -->

                                        @else

                                        <!-- DEV -->
                                        <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfEZyWaRn4fU4pEO2nvID-OqwnzB_ZcE4ImNH3PdQC_0_p2uA/viewform?usp=pp_url&entry.1937205043={{urlencode($projeto->titulo)}}&entry.609303703={{urlencode($projeto->nivel->nivel)}}&entry.152161166={{urlencode($projeto->areaConhecimento->area_conhecimento)}}&entry.970528430={{$projeto->id}}&entry.935053726={{urlencode(Auth::user()->nome)}}&entry.1538157001={{Auth::user()->id}}" id="novo-integrante" class="btn btn-success">
                                            Avaliar
                                        </a>

                                        <!-- PRODUÇÃO
                                        <a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLSfek9JgHhetqXhu1hZCLJpoCXGpNnYZsKClNF86dYFEOIWokw/viewform?usp=pp_url&entry.1937205043={{urlencode($projeto->titulo)}}&entry.609303703={{urlencode($projeto->nivel->nivel)}}&entry.152161166={{urlencode($projeto->areaConhecimento->area_conhecimento)}}&entry.970528430={{$projeto->id}}&entry.935053726={{urlencode(Auth::user()->nome)}}&entry.1538157001={{Auth::user()->id}}" id="novo-integrante" class="btn btn-success">
                                            Avaliar
                                        </a> -->

                                        @endif

                                     @endif

                                @endif

                            @else

                                @if((\App\Edicao::consultaPeriodo('Inscrição')))

                                    <a href="{{ route('editarProjeto', $projeto->id) }}" class="btn btn-success">
                                        Editar informações
                                    </a>

                                @endif

                            @endif

                            <br>

                            @if(!Auth::user()->temFuncao('Homologador') ||
                                !Auth::user()->temFuncao('Avaliador') ||
                                (Auth::user()->temFuncao('Administrador') || Auth::user()->temFuncao('Organizador')))

                            <b><i class="material-icons">group</i> Integrantes:</b><br>

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

                            @endif

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@if(Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Homologador'))

    @if((\App\Edicao::consultaPeriodo('Homologação')) && $ehHomologador)

    <script>
    $('#homologar-projeto').click(function () {

        //muda os atributos do botão depois de 3 segundos
        setTimeout(function () {
            $('#homologar-projeto').attr('href', '../../comissao-avaliadora');
            $('#homologar-projeto').attr('target', '');
            $('#homologar-projeto').html('Voltar')
        },3000);

    })
    </script>

    @endif

@endif


@endsection
