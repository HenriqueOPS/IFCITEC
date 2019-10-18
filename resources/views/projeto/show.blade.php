@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">

                <div class="row">
                    <div class="col-md-7 col-md-offset-1 col-xs-10 col-xs-offset-1">
                        <h2>{{$projeto->titulo}}</h2>
                    </div>
                </div>

                <div class="row">
                    <div id="projeto-show">

                        <div class="col-md-6 col-md-offset-1 col-xs-10 col-xs-offset-1">
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

                            <hr>

                            @if(count($obsHomologadores) && (!(\App\Edicao::consultaPeriodo('Homologação')) || Auth::user()->temFuncao('Administrador')))
                                <h3>Homologação:</h3>
                                @foreach($obsHomologadores as $obs)
									<b>Nota do Homologador {{$loop->index + 1}}:</b> <span>{{ $obs->nota_final }}</span><br>
                                    <b>Observação do Homologador {{$loop->index + 1}}:</b><br>
                                    <p>{{$obs->observacao}}</p>

                                    <hr>
                                @endforeach
                            @endif

                            @if(count($obsAvaliadores) && (!(\App\Edicao::consultaPeriodo('Avaliação')) || Auth::user()->temFuncao('Administrador')))
                                <h3>Avaliação:</h3>
                                @foreach($obsAvaliadores as $obs)
									<b>Nota do Avaliador {{$loop->index + 1}}:</b> <span>{{ $obs->nota_final }}</span><br>
                                    <b>Observação do Avaliador {{$loop->index + 1}}:</b><br>
                                    <p>{{$obs->observacao}}</p>

                                    <hr>
                                @endforeach
                            @endif

                        </div>

                        <div class="col-md-3 col-xs-10 col-xs-offset-1">

							@if(Auth::user()->temFuncao('Administrador') || (\App\Edicao::consultaPeriodo('Inscrição')))

								<a href="{{ route('editarProjeto', $projeto->id) }}" class="btn btn-success">
									Editar informações
								</a>

							@endif

                            @if(Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Homologador'))

                                @if((\App\Edicao::consultaPeriodo('Homologação')) && $ehHomologador)

									<a href="{{ route('formularioAvaliacao', ['homologacao', $projeto->id]) }}" id="botao-forms" class="btn btn-success">
										Homologar
									</a>

                                @endif

                                @if((\App\Edicao::consultaPeriodo('Avaliação')) && $ehAvaliador)

                                    @if($projeto->getStatus() != "Avaliado")

										<a href="{{ route('formularioAvaliacao', ['avaliacao', $projeto->id]) }}" id="botao-forms" class="btn btn-success">
											Avaliar
										</a>

                                     @endif

                                @endif

                            @endif

                            <br>

                            @if(!Auth::user()->temFuncao('Homologador') ||
                                !Auth::user()->temFuncao('Avaliador') ||
                                (Auth::user()->temFuncao('Administrador') || Auth::user()->temFuncao('Organizador')))

                            <b><i class="material-icons">group</i> Integrantes:</b><br>

                            @foreach($projeto->pessoas as $pessoa)
                                <b>{{App\Funcao::find($pessoa->pivot->funcao_id)->funcao}}: </b>{{$pessoa->nome}} ({{$pessoa->email}})<br>
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

    @if(((\App\Edicao::consultaPeriodo('Homologação')) && $ehHomologador) ||
        ((\App\Edicao::consultaPeriodo('Avaliação')) && $ehAvaliador))

    <script>
    $('#botao-forms').click(function () {

        console.log('Abrindo forms');

        //muda os atributos do botão depois de 1,5 segundos
        setTimeout(function () {
            $('#botao-forms').attr('href', '../../comissao-avaliadora');
            $('#botao-forms').attr('target', '');
            $('#botao-forms').html('Voltar')
        },1500);

    })
    </script>

    @endif

@endif


@endsection
