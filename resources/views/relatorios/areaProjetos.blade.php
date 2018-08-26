@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS DA ÁREA DO CONHECIMENTO {{$area->area_conhecimento}}</h2>


        <h5 style="font-size: 15px;">Número de projetos: {{$numeroProjetos}}</h5>

        <table class="bordered striped centered" style="width: 100%;">
        	<thead">
        		<tr>
            <th>#</th>
    				<th>Título</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $id => $projeto)
  				<tr>
            <td><a style="color: #000;">{{$id + 1}}</a></td>
    				<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection