@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE HOMOLOGADORES POR ÁREA</h2>
		<br>

		@foreach($homologadoresAreas as $homologadoresArea)

			<p style="text-align: center;">
				<b>{{ $homologadoresArea['area']->nivel }}: {{ $homologadoresArea['area']->area_conhecimento }}</b>
			</p>
			<br>

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
