@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 20px; margin-left: 250px;">RELATÓRIO DE EDIÇÕES</h2>

        <table style="margin-left: 25px; margin-left: 25px; margin-top: 50px; width: 100%;">
        	<thead">
        		<tr>
    				<th>Ano</th>
    				<th>Período da Feira</th> 
    				<th>Níveis</th>
    				<th>Áreas</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($edicoes as $edicao)
  				<tr>
    				<td>{{$edicao->ano}}</td>
    				<td>{{ date('d/m/Y H:i:s', strtotime($edicao['feira_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['feira_fechamento'])) }}</td> 
    				<td>
            @foreach(($edicao->niveis()->orderBy('nivel')->get()) as $nivel)  
              {{$nivel->nivel}}
              <br>
            @endforeach  
            </td>
    				<td>
            @foreach(($edicao->areas()->orderBy('area_conhecimento')->get()) as $area)  
              {{$area->area_conhecimento}}
              <br>
            @endforeach      
            </td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection

