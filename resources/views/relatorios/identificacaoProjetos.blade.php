@extends('relatorios.relatorioPaisagem')

@section('content')

<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
		<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE IDENTIFICAÇÃO DE PROJETOS</h2>
</header>

<div class="container">
	<div class="row">

		<table class="bordered striped centered" style="width: 100%">
			<thead>
				<tr>
					<th>Projeto</th>
					<th>Escola</th>
					<th>Localização</th>
				</tr>
			</thead>
			<tbody>
				@foreach($projetos as $bloco => $proj)
					@foreach($proj as $sala => $p)
						@foreach($p as $projeto)
						<tr>
						<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
						<td><a style="color: #000;">{{$projeto->nome_curto}}</a></td>
						<td><a style="color: #000;">{{$bloco}}{{$sala}}</a></td>
						</tr>
						@endforeach
					@endforeach
				@endforeach
			</tbody>
		</table>
		<br><br>
	</div>
</div>
@endsection
