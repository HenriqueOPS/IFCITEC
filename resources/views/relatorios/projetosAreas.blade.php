@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS POR NÍVEL E ÁREA</h4>
</header>
	<div class="container">
		<div class="row">
			<br>

			@foreach($projetosNivelArea as $projetosNivel)

				<h2 style="text-align: center; font-size: 20px;">{{ $projetosNivel['nivel']->nivel }}</h2>
				<br>

				@foreach($projetosNivel['projetosArea'] as $projetosArea)

					<p style="text-align: center;">
						<b>{{ $projetosArea['area']->area_conhecimento }}</b>
					</p>
					<br>

					<table class="bordered striped centered" style="width:100%;">
						<thead>
							<tr>
								<th>Titulo do Projeto</th>
							</tr>
						</thead>
						<tbody>

						@foreach($projetosArea['projetos'] as $projeto)

							<tr>
								<td>
									<a style="color: #000;">{{ $projeto->titulo }}</a>
								</td>
							</tr>

						@endforeach

						</tbody>
					</table>

					<p>
						<b>Total de Projetos: {{ count($projetosArea['projetos']) }}</b>
					</p>
					<br>

				@endforeach

				<br>
				<br>

			@endforeach

		</div>
	</div>
@endsection
