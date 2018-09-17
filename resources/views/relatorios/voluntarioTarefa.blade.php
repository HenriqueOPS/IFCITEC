@extends('relatorios.relatorio')


@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE VOLUNTÁRIOS E SUAS RESPECTIVAS TAREFAS</h2>

        <table class="bordered striped centered" style="width: 100%;">
        	<thead">
        		<tr>
    				<th>Nome</th>
            <th>Email</th>
            <th>Tarefa</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($voluntarios as $id => $voluntario)
  				<tr>
    				<td><a style="color: #000;">{{$voluntario->nome}}</a></td>
            <td><a style="color: #000;">{{$voluntario->email}}</a></td>
            <td><a style="color: #000;">{{\App\Pessoa::find($voluntario->id)->tarefas->first()->tarefa}}</a></td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection