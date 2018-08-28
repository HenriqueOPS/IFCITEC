@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE VOLUNTÁRIOS DA TAREFA</h2>
        <h2 style="text-align: center; font-size: 25px;">{{$tarefa->tarefa}}</h2>

        <div>
        <table class="bordered striped centered" style="width: 100%;">
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
</div>
@endsection