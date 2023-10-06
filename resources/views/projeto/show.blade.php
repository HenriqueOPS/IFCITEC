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
                    @if(isset($projeto->localizacao))
                        <p><b>Localizacao:</b> Prédio-Sala-Estande, {{ $projeto->localizacao }}</p>
                        <hr>
                    @endif
                                                <?php
						
						$dataCitada = \Carbon\Carbon::parse($datahom);
						$umDiaDepois = $dataCitada->copy()->addSecond();
						?>
                        	@if(isset($projeto->nota_avaliacao) && $projeto->nota_avaliacao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($dataava) )
                            <strong>Nota Final da Avaliação: {{ number_format($projeto->nota_avaliacao, 2) }}</strong><br>
                            @endif
								@if(isset($projeto->nota_revisao) && $projeto->nota_revisao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($umDiaDepois) )
							
								<strong>Nota Final da Homologação: {{ number_format($projeto->nota_revisao, 2) }}</strong>
                                	
						
                                <hr>
								
                            <div class="row">
                            <div class="col-md-12  ">
                                <h3><b>Homologação</b></h3>
                                <hr>
                            </div>
                        </div>
                       
                        <div class="row">
                                    <div class="col-md-7 ">
                                     <strong>Nota do Homologador 1: </strong>{{ number_format($homologacao[0][0]->nota_final, 2)}}
                                
                                    </div>
                        </div>
                        <br>
                        @foreach($homologacao[0] as $campo)
                        <div class="row">
                        <div class="col-md-12">
                        @php
                            $id = $campo->categoria_avaliacao;
                        @endphp
                        <div id="{{ $id }}" class="campo"  ><b>{{ $campo->categoria_avaliacao }}</b></div>-{{ $campo->descricao }}:<strong>{{ $campo->valor }}</strong>
                    </div>

                    <script>
                        // Vamos supor que você queira selecionar o primeiro elemento com um ID específico, por exemplo, "exemploId".
                        var id = '{{ $id }}';

                        // Seleciona todos os elementos com o mesmo ID
                        var elementos = document.querySelectorAll('#' + id);

                        // Esconde todos os elementos, exceto o primeiro
                        for (var i = 1; i < elementos.length; i++) {
                            elementos[i].style.display = 'none';
                        }
                    </script>


                        </div>
                   
                    @endforeach
                    
                        
                        <div class="row" id="selects">
                                <div class="col-md-10 ">
                                   
                                      <br>
                                     <strong>Observação do Homologador 1: </strong>{{$homologacao[0][0]->observacao}}
                                   
                                </div>
                        </div>
                        <br>
                        <hr>
                      
                        <div class="row">
                                    <div class="col-md-7 ">
                                    <strong>Nota do Homologador 2: </strong>{{ number_format($homologacao[1][0]->nota_final, 2)}}
                                    </div>
                                   
                                    
                        </div>
                        <br>
                        @foreach($homologacao[1] as $campo)
                        <div class="row">
                        <div class="col-md-12">
                        @php
                        $id = str_replace(' ', '', $campo->categoria_avaliacao) . '2';
                        @endphp
                       
                        <div id='{{ $id }}' class="campo"  ><b>{{ $campo->categoria_avaliacao }}</b></div>-{{ $campo->descricao }}:<strong>{{ $campo->valor }}</strong>
                    </div>

                    <script>
                        // Vamos supor que você queira selecionar o primeiro elemento com um ID específico, por exemplo, "exemploId".
        
                        var id = '{{ $id }}';
                        // Seleciona todos os elementos com o mesmo ID
                        var elementos = document.querySelectorAll('#' + id);

                        // Esconde todos os elementos, exceto o primeiro
                        for (var i = 1; i < elementos.length; i++) {
                            elementos[i].style.display = 'none';
                        }
                    </script>


                        </div>
                   
                    @endforeach
                     
                        
                        <div class="row">
                                <div class="col-md-10 ">
                                <br>
                                    <strong>Observação do Homologador 2: </strong>  {{$homologacao[1][0]->observacao}}
                                    
                                </div>
                        </div>
                        <br>
    
                           
    
								@endif
								<br>
                                <?php
						
						$dataCitada = \Carbon\Carbon::parse($dataava);
						$umDiaDepois = $dataCitada->copy()->addSecond();
						?>
							
				
							@if(isset($projeto->nota_avaliacao) && $projeto->nota_avaliacao !== null && \Carbon\Carbon::now()->greaterThanOrEqualTo($umDiaDepois))					
                            <hr>
                            <div class="row">
                            <div class="col-md-12  ">
                                <h3><b>Avaliacão</b></h3>
                                <hr>
                            </div>
                        </div>
                   
                    <div class="row">
                                <div class="col-md-7 ">
                                 <strong>Nota do Avaliador 1: </strong>{{ number_format($avaliacao[0][0]->nota_final, 2)}}
							
                                </div>
                    </div>
                    <br>

                    @php
                    // Defina a função de comparação para usar no usort
                    function compararCampos($a, $b) {
                        return strcmp($a->categoria_avaliacao, $b->categoria_avaliacao);
                    }

                    // Crie uma cópia do array $avaliacao[1] para ordenação
          
                    usort($avaliacao[0], 'compararCampos');
                    @endphp
					@foreach($avaliacao[0] as $campo)
					<div class="row">
                    <div class="col-md-12">
                        @php
                        $id = str_replace(' ', '', $campo->categoria_avaliacao) . '3';
                        @endphp
                        <div id="{{ $id }}" class="campo"  ><b>{{ $campo->categoria_avaliacao }}</b></div>-{{ $campo->descricao }}:<strong>{{ $campo->valor }}</strong>
                    </div>

                    <script>
                        // Vamos supor que você queira selecionar o primeiro elemento com um ID específico, por exemplo, "exemploId".
                        var id = '{{ $id }}';
                        // Seleciona todos os elementos com o mesmo ID
                        var elementos = document.querySelectorAll('#' + id);

                        // Esconde todos os elementos, exceto o primeiro
                        for (var i = 1; i < elementos.length; i++) {
                            elementos[i].style.display = 'none';
                        }
                    </script>


					</div>
                
				@endforeach
				
					
                    <div class="row" id="selects">
                            <div class="col-md-10 ">
                            <br>
                                  
                                 <strong>Observação do Avaliador 1: </strong>{{$avaliacao[0][0]->observacao}}
                               
                            </div>
                    </div>
                    <br>
                    <hr>
                  @if(array_key_exists(1,$avaliacao))
                    <div class="row">
                                <div class="col-md-7 ">
                                <strong>Nota do Avaliador 2: </strong> {{ number_format($avaliacao[1][0]->nota_final, 2)}}
                                </div>
								
                    </div>
                    <br>
                                        @php
                    // Defina a função de comparação para usar no usort
                    function compararCampos($a, $b) {
                        return strcmp($a->categoria_avaliacao, $b->categoria_avaliacao);
                    }

                    // Crie uma cópia do array $avaliacao[1] para ordenação
          
                    usort($avaliacao[1], 'compararCampos');
                    @endphp
					@foreach($avaliacao[1] as $campo)
					<div class="row">
                    <div class="col-md-12">
                        @php
                        $id = str_replace(' ', '', $campo->categoria_avaliacao) . '4';
                        @endphp
                        <div id="{{ $id }}" class="campo"  ><b>{{ $campo->categoria_avaliacao }}</b></div>-{{ $campo->descricao }}:<strong>{{ $campo->valor }}</strong>
                    </div>

                    <script>
                        // Vamos supor que você queira selecionar o primeiro elemento com um ID específico, por exemplo, "exemploId".
                        var id = '{{ $id }}';

                        // Seleciona todos os elementos com o mesmo ID
                        var elementos = document.querySelectorAll('#' + id);

                        // Esconde todos os elementos, exceto o primeiro
                        for (var i = 1; i < elementos.length; i++) {
                            elementos[i].style.display = 'none';
                        }
                    </script>


					</div>
                
				@endforeach
                 
					
                    <div class="row">
                            <div class="col-md-10 ">
                            <br>
                                <strong>Observação do Avaliador 2: </strong>  {{$avaliacao[1][0]->observacao}}
                                
                            </div>
                    </div>
                    <br>
					@endif
							@endif

                        </div>

                        <div class="col-md-3 ">

							@if(Auth::user()->temFuncao('Administrador') || (\App\Edicao::consultaPeriodo('')))

								<a href="{{ route('editarProjeto', $projeto->id) }}" class="btn btn-success">
									Editar informações
								</a>Inscrição

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
