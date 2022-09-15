@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE AVALIADORES POR ÁREA</h2>
</header>
<div class="container">
    <div class="row">
        @foreach($areas as $area)
        <p style="text-align: center;"><b> {{$area->nivel}} : {{$area->area_conhecimento}}</b></p>
        <br>

		<table class="bordered striped centered" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
			<thead>
				<tr>
				  <th>Nome</th>
				</tr>
			</thead>

			<tbody>
			  @foreach($area->avaliadores as $avaliador)
			  <tr>
				<td><a style="color: #000;">{{$avaliador->nome}}</a></td>
			  </tr>
			  @endforeach
			</tbody>

		</table>

		<p><b> Total de Avaliadores: {{ count($area->avaliadores) }}</b></p>
        <br>
        @endforeach
	</div>
</div>
@endsection

