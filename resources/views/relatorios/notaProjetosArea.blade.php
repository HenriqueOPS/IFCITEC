@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS CADASTRADOS POR NOTA</h2>

        <table class="bordered striped centered" style="width: 100%">
        	<thead>
        		<tr>
    				<th>Projeto</th>
            <th>Nível</th>
            <th>Área do Conhecimento</th>
    				<th>Nota Final</th> 
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $projeto)
          
  				<tr>
    				<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
            <td><a style="color: #000;">{{$projeto->nivel}}</a></td>
            <td><a style="color: #000;">{{$projeto->area_conhecimento}}</a></td>  
    				<td><a style="color: #000;">{{$projeto->nota}}</a></td>

  				</tr>
         
          @endforeach
  			</tbody>	
		</table> 
	</div>
</div>
@endsection

