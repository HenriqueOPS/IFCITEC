@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS QUE COMPARECERAM NA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC POR AUTOR</h2>

      
      <table class="bordered striped centered" style="width: 100%">
        	<thead>
        	<tr>
    				<th>Autor</th>
            <th>Título do Projeto</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($autores as $autor)
  				<tr>
    				<td><a style="color: #000;">{{$autor->nome}}</a></td>
            <td><a style="color: #000;">{{$autor->titulo}}</a></td>
  				</tr>
          @endforeach
  			</tbody>	
		</table> 
    <br><br>
	</div>
</div>
@endsection
