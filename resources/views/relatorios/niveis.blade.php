@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 5mm; margin-left: 70mm;">RELATÓRIO DE NÍVEIS</h2>

        <table style="margin-left: 25mm; margin-top: 10mm;">
        	<thead>
        		<tr>
    				<th>Nível</th>
    				<th>Descrição</th> 
    				<th>Palavras-Chave</th>
    				<th>Caracteres Mínimos (Resumo)</th>
    				<th>Caracteres Máximos (Resumo)</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($niveis as $nivel)
  				<tr>
    				<td>{{$nivel->nivel}}</td>
    				<td>{{$nivel->descricao}}</td> 
    				<td>{{$nivel->palavras}}</td>
    				<td>{{$nivel->min_ch}}</td>
    				<td>{{$nivel->max_ch}}</td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection

