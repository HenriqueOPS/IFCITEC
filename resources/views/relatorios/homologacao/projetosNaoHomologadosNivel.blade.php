@extends('relatorios.relatorioPaisagem')

@section('content')
	<div class="container">
		<div class="row">
			<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS NÃO HOMOLOGADOS {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC</h2>

			@foreach($niveis as $nivel)
			<p style="text-align: center;"><b>{{$nivel->nivel}}</b></p>
			<table class="bordered striped centered" style="width: 100%">
				<thead>
					<tr>
						<th>Projeto</th>
						<th>Nota Final</th>
					</tr>
				</thead>
				<tbody>

				@foreach($nivel->getProjetosNaoHomologados($nivel->id, $edicao) as $projeto)
					<tr>
						<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
						<td><a style="color: #000;">{{$projeto->nota}}</a></td>
					</tr>
				@endforeach

				</tbody>
			</table>
			<br><br>
			@endforeach
		</div>
	</div>
@endsection