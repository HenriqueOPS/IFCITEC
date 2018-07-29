@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 20px; margin-left: 200px;">RELATÓRIO DE VOLUNTÁRIOS E SUAS RESPECTIVAS TAREFAS</h2>

        <table style="margin-left: 25px; margin-top: 50px; width: 100%;">
        	<thead">
        		<tr>
            <th>#</th>
    				<th>Nome</th>
            <th>Email</th>
            <th>Tarefa</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($voluntarios as $id => $voluntario)
  				<tr>
            <td>{{$id + 1}}</td>
    				<td>{{$voluntario->nome}}</td>
            <td>{{$voluntario->email}}</td>
            <td>{{\App\Pessoa::find($voluntario->id)->tarefas()->first()->tarefa}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection