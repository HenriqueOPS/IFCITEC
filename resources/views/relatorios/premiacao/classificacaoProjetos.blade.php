@extends('relatorios.relatorioPaisagem')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DA CLASSIFICAÇÃO GERAL POR ÁREA DO CONHECIMENTO DA {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</h2>
</header>
<div class="container">
    <div class="row">

		@foreach($areas as $area)
		<p style="text-align: center;"><b>{{$area->niveis->nivel}} : {{$area->area_conhecimento}}</b></p>
		<table class="bordered striped centered" style="width: 100%">
			<thead>
				<tr>
					<th>Projeto</th>
					<th>Escola</th>
					<th>Nota Final</th>
				</tr>
			</thead>
			<tbody>
			@foreach($area->getClassificacaoProjetos($area->id, $edicao) as $projeto)
				<tr>
					<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
					<td><a style="color: #000;">{{$projeto->nome_curto}}</a></td>
					<td><a style="color: #000;">{{$projeto->nota_avaliacao}}</a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
		<br><br>
		@endforeach
	</div>
</div>
@endsection
