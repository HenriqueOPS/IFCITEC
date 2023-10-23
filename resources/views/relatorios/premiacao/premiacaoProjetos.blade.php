@extends('relatorios.relatorioPaisagem')

@section('content')
<style>
  body {
    background-image: url(data:image/png;base64,{{$fundo}});
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
  }
</style>
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PREMIAÇÃO DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC</h2>
</header>
<div class="container">
    <div class="row">

		@foreach($areas as $area)
		<p style="text-align: center;"><b>{{$area->niveis->nivel}} : {{$area->area_conhecimento}}</b></p>
		<table class="bordered striped centered" style="width: 100%">
			<thead>
				<tr>
					<th>Colocação</th>
					<th>Projeto</th>
					<th>Escola</th>
					<th>Nota Final</th>
					<th>Autor(es)</th>
					<th>Orientador</th>
					<th>Coorientador(es)</th>
				</tr>
			</thead>
			<tbody>

				@php
					$projetos = $area->getClassificacaoProjetosCertificados($area->id, $edicao);
					$cont = count($projetos);
				@endphp

				@foreach($projetos as $projeto)

				@if($projeto->situacao_id == \App\Situacao::where('situacao', 'Avaliado')->get()->first()->id)
				<tr>
					<td><a style="color: #000;">{{$cont--}}</a></td>
					<td><a style="color: #000;">{{$projeto->titulo}}</a></td>
					<td><a style="color: #000;">{{$projeto->nome_curto}}</a></td>
					<td><a style="color: #000;">{{$projeto->nota_avaliacao}}</a></td>
					<td>
						@foreach($projeto->getAutores() as $autor)
							{{$autor->nome}},
						@endforeach
					</td>
					<td>
						@foreach($projeto->getOrientador() as $orientador)
							{{$orientador->nome}}
						@endforeach
					</td>
					<td>
						@foreach($projeto->getCoorientadores() as $coorientador)
							@if(isset($coorientador->nome))
								{{$coorientador->nome}},
							@endif
						@endforeach
					</td>
				</tr>
				@endif

				@endforeach

			</tbody>
		</table>
		<br><br>
		@endforeach
	</div>
</div>

@endsection
