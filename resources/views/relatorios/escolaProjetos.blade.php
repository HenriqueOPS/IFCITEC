@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <div>
        <h2 style=" margin: auto; margin-top: 40px; vertical-align: center; text-align: center;">RELATÓRIO DE PROJETOS DA ESCOLA <br>{{$escola->nome_curto}}</h2>
        </div>

        <div>
        <h5 style="margin-top: 100px; margin-left: 20px;">Número de projetos: {{$numeroProjetos}}</h5>
        </div>

        <div>
        <table style="margin: auto; margin-top: 40px; margin-left: 20px; margin-right: 20px; width: 100%;">
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
</div>
@endsection
