@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <div>
        <h2 style="margin-top: 10mm; margin-left: 20mm;">RELATÓRIO DE VOLUNTÁRIOS DA TAREFA <br> {{$tarefa->tarefa}} <br></h2>
        </div>

        <div>
        <table style="margin: auto; margin-top: 150mm; margin-left: 20mm; margin-right: 20mm; width: 100%;">
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