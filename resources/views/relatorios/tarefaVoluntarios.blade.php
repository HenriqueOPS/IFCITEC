@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 20px; margin-left: 200px;">RELATÓRIO DE VOLUNTÁRIOS DA TAREFA {{$tarefa->tarefa}}</h2>

        <table style="margin-left: 25px; margin-top: 50px; width: 100%;">
        	<thead">
        		<tr>
            <th>#</th>
    				<th>Nome</th>
            <th>Email</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($tarefa->pessoas as $id => $pessoa)
  				<tr>
            <td>{{$id + 1}}</td>
    				<td>{{$pessoa->nome}}</td>
            <td>{{$pessoa->email}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection