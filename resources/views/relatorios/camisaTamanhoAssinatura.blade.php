@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE TAMANHO DE CAMISAS DOS AUTORES (ASSINATURA)
        </h5>
        <br>
        <table class="bordered striped centered" style="width:100%;">
        	<thead>
        		<tr>
    				<th>Autores</th>
                    <th>Tamanho</th>
                    <th>Assinatura</th>
  				</tr>
        	</thead>
  			<tbody>
            {{$cont = 0}}
            @foreach($autores as $autor)
            <tr>
            <td>
    		<a style="color: #000;">{{$autor->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$autor->camisa}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach	
  			</tbody>	
		  </table>
        <br>
	</div>
</div>
@endsection