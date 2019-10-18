@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE NÍVEIS</h2>

        <table class="bordered striped centered" style="width: 100%">
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
    				<td><a style="color: #000;">{{$nivel->nivel}}</a></td>
    				<td><a style="color: #000;">{{$nivel->descricao}}</a></td> 
    				<td><a style="color: #000;">{{$nivel->palavras}}</a></td>
    				<td><a style="color: #000;">{{$nivel->min_ch}}</a></td>
    				<td><a style="color: #000;">{{$nivel->max_ch}}</a></td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection

