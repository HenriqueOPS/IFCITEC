@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 20px; margin-left: 200px;">RELATÓRIO DE USUÁRIOS E SUAS RESPECTIVAS FUNÇÕES</h2>

        <table style="margin-left: 25px; margin-left: 25px; margin-top: 50px; width: 100%;">
        	<thead">
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
            @foreach($funcoes as $funcao)
              @if($usuario->temFuncao($funcao->funcao))
                  {{$funcao->funcao}}
                  <br>
              @endif
            @endforeach    
            </td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection

