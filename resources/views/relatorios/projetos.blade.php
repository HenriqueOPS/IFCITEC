@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS</h2>

	<table class="bordered striped centered" style="width: 100%;">
		<thead>
			<tr>
				<th>Projeto</th>
				<th>Escola</th>
				<th>Autor(es)</th>
				<th>Orientador</th>
				<th>Coorientador(es)</th>
			</tr>
		</thead>
		<tbody>

			@foreach($projetos as $projeto)

			<tr>
				<td>{{$projeto->titulo}}</td>
				<td>{{(\App\Escola::find($projeto->escola_id))->nome_curto}}</td>
				<td>
				  @foreach($projeto->getAutores() as $autor)

				  <a style="color: #000;">{{$autor->nome}}</a>
				  <br>

				  @endforeach
				</td>
				<td>
				  @foreach($projeto->getOrientador() as $orientador)

				  <a style="color: #000;">{{$orientador->nome}}</a>

				  @endforeach
				</td>
				<td>
				  @foreach($projeto->getCoorientadores() as $coorientador)

				  <a style="color: #000;">{{$coorientador->nome}}</a>
				  <br>

				  @endforeach
				</td>
			</tr>
			@endforeach
		</tbody>

	</table>
	</div>
</div>
@endsection
