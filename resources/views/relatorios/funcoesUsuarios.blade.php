@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE USUÁRIOS E SUAS RESPECTIVAS FUNÇÕES</h2>

        <table class="bordered striped centered" style="width: 100%;">
        	<thead>
        		<tr>
    				<th>Usuário</th>
            <th>Email</th>
    				<th>Funções</th> 
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($usuarios as $usuario)
  				<tr>
    				<td>{{$usuario->nome}}</td>
    				<td>{{$usuario->email}}</td> 
    				<td>
            @foreach($usuario->funcoes as $funcao)
                {{$funcao->funcao}}
                <br>
            @endforeach    
            </td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection

