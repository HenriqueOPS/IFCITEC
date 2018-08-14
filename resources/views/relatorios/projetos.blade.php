@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 5mm; margin-left: 65mm;">RELATÓRIO DE PROJETOS</h2>

        <table style="margin-top: 10mm; width: 100%;">
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
    				<td style="margin-left: 3pt; border-bottom:solid 1pt #000;">{{$projeto->titulo}}</td> 
    				<td style="margin-left: 3pt; border-bottom:solid 1pt #000;">{{(\App\Escola::find($projeto->escola_id))->nome_curto}}</td>
    				<td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
              @foreach($autores as $autor)
              @if($autor->projeto_id == $projeto->id)
              {{$autor->nome}}
              <br>
              @endif
              @endforeach
            </td>
    				<td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
              @foreach($orientadores as $orientador)
              @if($orientador->projeto_id == $projeto->id)
              {{$orientador->nome}}</td>
              @endif
              @endforeach
            <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
              @foreach($coorientadores as $coorientador)
              @if($coorientador->projeto_id == $projeto->id)
              {{$coorientador->nome}}
              <br>
              @endif
              @endforeach
            </td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection