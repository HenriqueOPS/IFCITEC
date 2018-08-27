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

    				<td><a style="color: #000;">{{$usuario->nome}}</a></td>
    				<td><a style="color: #000;">{{$usuario->email}}</a></td> 
    				<td>
            @foreach($usuario->funcoes as $funcao)
                @if($usuario->temFuncao($funcao->funcao))
                <a style="color: #000;">{{$funcao->funcao}}</a>
                @endif
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

