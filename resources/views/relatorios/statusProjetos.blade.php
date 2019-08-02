@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 20px;">RELATÓRIO DE PROJETOS E SEUS STATUS</h2>

        <table class="bordered striped centered" style="width: 100%">
        	<thead>
        		<tr>
    				<th>Nome</th>
            		<th>Status</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $projeto)
  				<tr>
    				<td>{{$projeto->titulo}}</td>
            		<td>{{$projeto->situacao}}</td>
  				</tr>
  				@endforeach
  			</tbody>

		</table>
	</div>
</div>
@endsection
