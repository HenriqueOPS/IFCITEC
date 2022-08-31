@extends('relatorios.relatorio')

@section('content')

<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE HOMOLOGADORES POR ÁREA</h2>
</header>

<div class="container">
    <div class="row">
		@foreach($homologadoresAreas as $homologadoresArea)

			<p style="text-align: center;">
				<b>{{ $homologadoresArea['area']->nivel }}: {{ $homologadoresArea['area']->area_conhecimento }}</b>
			</p>

			<table class="bordered striped centered" style="width:100%;">
				<thead>
					<tr>
						<th>Nome</th>
					</tr>
				</thead>
				<tbody>

				@foreach($homologadoresArea['homologadores'] as $homologador)

					<tr>
						<td>
							<a style="color: #000;">{{ $homologador->nome }}</a>
						</td>
					</tr>

				@endforeach

				</tbody>
			</table>

			<p>
				<b>Total de Avaliadores: {{ count($homologadoresArea['homologadores']) }}</b>
			</p>
			<br>
		@endforeach

	</div>
</div>
@endsection
