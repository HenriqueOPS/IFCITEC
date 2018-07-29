@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 20px; margin-left: 200px;">RELATÓRIO DE PROJETOS DA ÁREA DO CONHECIMENTO {{$area->area_conhecimento}}</h2>


        <h5 style="margin-top: 30px; margin-left: 20px;">Número de projetos: {{$numeroProjetos}}</h5>

        <table style="margin-left: 25px; margin-top: 50px; width: 100%;">
        	<thead">
        		<tr>
            <th>#</th>
    				<th>Título</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $id => $projeto)
  				<tr>
            <td>{{$id + 1}}</td>
    				<td>{{$projeto->titulo}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection