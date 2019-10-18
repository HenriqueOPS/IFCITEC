@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">

        @if((\App\Edicao::consultaPeriodo('Homologação')))
            <h2>Homologar Projetos</h2>
        @else
            <h2>Avaliar Projetos</h2>
        @endif

        </div>

    </div>
</div>
<br><br>
<div class="container">

    <div class="row">

        <div class="col-md-12 main main-raised">

            <div class="list-projects">

                @foreach($projetos as $projeto)

                    <div class="row project">

                    <div class="col-md-10">
                        <div class="project-title">
                            @if(!in_array($projeto->id, $idOk))

								@if(\App\Edicao::consultaPeriodo('Homologação'))
									<span><a href="{{ route('formularioAvaliacao', ['homologacao', $projeto->id]) }}">{{$projeto->titulo}}</a></span>
								@elseif(\App\Edicao::consultaPeriodo('Avaliação'))
									<span><a href="{{ route('formularioAvaliacao', ['avaliacao', $projeto->id]) }}">{{$projeto->titulo}}</a></span>
								@endif

                            @else
                                <span>{{$projeto->titulo}}</span>
                            @endif
                        </div>

                        @if((\App\Edicao::consultaPeriodo('Avaliação')))

                        <div class="project-info">
                            Integrantes:
                            @foreach($projeto->pessoas as $pessoa)
                                {{$pessoa->nome}},
                            @endforeach
                        </div>

                        @endif

                    </div>

                    <div class="col-md-2 actions text-center">

                        <div class="status">
                            @if(in_array($projeto->id, $idOk))

                                @if((\App\Edicao::consultaPeriodo('Homologação')))
                                    <span class="label label-success">Homologado</span>
                                @else
                                    <span class="label label-success">Avaliado</span>
                                @endif

                            @else

                                @if($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Não Avaliado")
                                    <span class="label label-info">{{$projeto->getStatus()}}</span>
                                @elseif ($projeto->getStatus() == "Homologado" || $projeto->getStatus() == "Avaliado")
                                    <span class="label label-success">{{$projeto->getStatus()}}</span>
                                @elseif ($projeto->getStatus() == "Não Compareceu")
                                    <span class="label label-danger">{{$projeto->getStatus()}}</span>
                                @else
                                    <span class="label label-default">{{$projeto->getStatus()}}</span>
                                @endif

                            @endif
                        </div>

                    </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>
</div>

@endsection
