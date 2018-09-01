@extends('relatorios.relatorio')

@section('content')
	<div class="container">
		<div class="row">
			<h2 style="text-align: center; font-size: 25px;">PROJETOS HOMOLOGADOS PARA A {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</h2>

				<table class="bordered striped centered" style="width: 100%">
					<thead>
					<tr>
						<th>Título do Projeto</th>
					</tr>
					</thead>
					<tbody>
					@foreach($projetos as $projeto)
						<tr>
							<td><b><a style="color: #000;">{{$projeto->titulo}}</b></a></td>
						</tr>
					@endforeach
					</tbody>
				</table>
				<br><br>
		</div>
	</div>
@endsection
