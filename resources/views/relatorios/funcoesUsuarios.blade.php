@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 5mm; margin-left: 12mm;">RELATÓRIO DE USUÁRIOS E SUAS RESPECTIVAS FUNÇÕES</h2>

        <table style="margin-left: 25mm; margin-top: 10mm; width: 100%;">
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
    				<td style="border-bottom:solid 1px #000;">{{$usuario->nome}}</td>
    				<td style="border-bottom:solid 1px #000;">{{$usuario->email}}</td> 
    				<td style="border-bottom:solid 1px #000;">
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

