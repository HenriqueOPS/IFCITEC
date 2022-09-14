@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
        <h2 style="text-align: center; font-size: 20px;">RELATÓRIO DE PROJETOS QUE COMPARECERÃO NA IFCITEC</h2>
</header>
<div class="container">
    <div class="row">

        <table class="bordered striped centered" style="width: 100%">
        	<thead>
        		<tr>
    				<th>Nome</th>
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
	</div>
</div>
@endsection
