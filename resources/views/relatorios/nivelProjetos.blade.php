@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 5mm; margin-left: 50mm;">RELATÓRIO DE PROJETOS DO NÍVEL </h2>
        <h2 style="text-align: center;">{{$nivel->nivel}}</h2>


        <h5 style="margin-top: 10mm; margin-left: 20mm;">Número de projetos: {{$numeroProjetos}}</h5>

        <table style="margin-left: 25mm; margin-top: 10mm; width: 100%;">
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