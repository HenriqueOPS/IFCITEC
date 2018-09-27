@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PREMIAÇÃO DA {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</h2>

      @foreach($areas as $area)
      <p style="text-align: center;"><b>{{$area->niveis->nivel}} : {{$area->area_conhecimento}}</b></p>
      <table class="bordered striped centered" style="width: 100%">
        	<thead>
        	<tr>
            <th>Colocação</th>
    				<th>Projeto</th>
            <th>Escola</th>
    				<th>Nota Final</th> 
            <th>Autor(es)</th> 
            <th>Orientador</th> 
            <th>Coorientador(es)</th> 
  				</tr>
        	</thead>
  			<tbody>
          {{$cont = 3}}
          {{$projetos = $area->getClassificacaoProjetosCertificados($area->id)}}
  				@foreach($projetos as $projeto)
          @if($cont >= 3)
            @break
          @endif
          @if($projeto->situacao_id == \App\Situacao::where('situacao', 'Avaliado')->get()->first()->id)
  				<tr>
            <td><a style="color: #000;">{{$cont - 1}}</a></td>
    				<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
            <td><a style="color: #000;">{{$projeto->nome_curto}}</a></td>
    				<td><a style="color: #000;">{{$projeto->nota_avaliacao}}</a></td>
            {{$coorientadores = $projeto->getCoorientadores($projeto->id)}}
            {{$orientador = $projeto->getOrientador($projeto->id)}}
            {{$autores = $projeto->getAutores($projeto->id)}}
            <td>
            @foreach($autores as $autor)
            {{$autor->nome}},
            @endforeach
            </td>
            <td>
            @foreach($orientador as $o)
            {{$o->nome}}
            @endforeach
            </td>
            <td> 
            @foreach($coorientadores as $coorientador)
            @if(isset($coorientador->nome))
            {{$coorientador->nome}},
            @endif
            @endforeach
            </td>

  				</tr>
          {{$cont++}}
          @endif
          @endforeach
  			</tbody>	
		</table> 
    <br><br>
    @endforeach
	</div>
</div>
@endsection