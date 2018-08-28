@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS DO NÍVEL </h2>
        <h2 style="text-align: center; font-size: 25px;">{{$nivel->nivel}}</h2>


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
            <td>{{$id + 1}}</td>
    				<td>{{$projeto->titulo}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection