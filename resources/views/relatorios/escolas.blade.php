@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 20px; margin-left: 250px;">RELATÓRIO DE ESCOLAS</h2>

        <table style="margin-left: 25px; margin-left: 25px; margin-top: 50px;">
        	<thead">
        		<tr>
    				<th>Escola</th>
    				<th>Município</th> 
    				<th>Email</th>
    				<th>Telefone</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($escolas as $escola)
  				<tr>
    				<td>{{$escola->nome_curto}}</td>
    				<td>{{$escola->municipio}}</td> 
    				<td>{{$escola->email}}</td>
    				<td>{{$escola->telefone}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection
