@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 20px;">RELATÓRIO DE PROJETOS QUE COMPARECERÃO NA IFCITEC</h2>

        <table class="bordered striped centered" style="width: 100%">
        	<thead>
        		<tr>
    				<th>Nome</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $projeto)
  				<tr>
    				<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection