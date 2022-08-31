@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE HOMOLOGADORES POR PROJETO</h2>
</header>

	<div class="container">
		<div class="row">
			@foreach($projetos as $projeto)
				<table class="bordered striped centered" style="width: 100%;">
				<thead>
					<tr>
						<th>{{$projeto->titulo}}</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<td>
							<a style="color: #000;"> Homologadores: </a>
							@foreach($projeto->revisoes as $revisao)
									<a style="color: #000;">{{$revisao->pessoa->nome}}, </a>
							@endforeach
					</td>
					</tr>
				</tbody>
				</table>
				<br>
			@endforeach

		</div>
	</div>

@endsection

