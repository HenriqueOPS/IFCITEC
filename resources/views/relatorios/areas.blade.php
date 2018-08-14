@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 3mm; margin-left: 35mm; margin-right: 20mm;">RELATÓRIO DE ÁREAS DO CONHECIMENTO</h2>

        <table style="margin-left: 25mm; margin-top: 10mm; width: 100%">
        	<thead">
        		<tr>
    				<th>Área do Conhecimento</th>
    				<th>Nível</th> 
    				<th>Descricao</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($areas as $area)
  				<tr>
    				<td>{{$area->area_conhecimento}}</td>
    				<td>{{$area->niveis()->first()->nivel}}</td> 
    				<td>{{$area->descricao}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection
