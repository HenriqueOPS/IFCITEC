@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DA CLASSIFICAÇÃO GERAL DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC</h2>

      @foreach($niveis as $nivel)
        <p style="text-align: center;"><b>{{$nivel->nivel}}</b></p>
      <table class="bordered striped centered" style="width: 100%">
        	<thead>
        	<tr>
    				<th>Projeto</th>
            <th>Escola</th>
    				<th>Nota Final</th>
  				</tr>
        	</thead>
  			<tbody>
          {{$projetos = $nivel->getClassificacao($nivel->id, $edicao)}}
  				@foreach($projetos as $projeto)
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
