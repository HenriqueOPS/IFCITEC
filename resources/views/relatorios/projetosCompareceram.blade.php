@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS QUE COMPARECERAM NA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC</h2>
</header>
<div class="container">
    <div class="row">

      
      <table class="bordered striped centered" style="width: 100%">
        	<thead>
        	<tr>
    				<th>Título</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $projeto)
  				<tr>
    				<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
  				</tr>
          @endforeach
  			</tbody>	
		</table> 
    <br><br>
	</div>
</div>
@endsection
