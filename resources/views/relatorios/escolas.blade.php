@extends('relatorios.relatorio')


@section('content')
        <h2 style=" margin-left: 250px;">RELATÓRIO DE ESCOLAS</h2>

        <table style="margin-left: 25px; margin-left: 25px;">
        	<thead>
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
    				<td>
              @if($escola->enderecos != null)
              {{$escola->enderecos->first()->municipio}}
              @endif
            </td> 
    				<td>{{$escola->email}}</td>
    				<td>{{$escola->telefone}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
		</table> 
@endsection
