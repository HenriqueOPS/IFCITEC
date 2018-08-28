@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE ÁREAS DO CONHECIMENTO</h2>

        <table class="bordered striped centered" style="width: 100%">
        	<thead>
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
