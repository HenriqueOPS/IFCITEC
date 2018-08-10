@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center;">RELATÓRIO DE AVALIADORES POR PROJETO</h2>

        <table style="margin-left: 25mm; margin-top: 10mm; width: 100%;">
        	<thead>
        		<tr>
    				<th>Projeto</th>
            <th>Avaliadores</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $projeto)
  				<tr>
    				<td style="border-bottom:solid 1px #000;">{{$projeto->titulo}}</td>
    				<td style="border-bottom:solid 1px #000;">
            @foreach($avaliadores as $avaliador)
              @foreach($avaliador->avaliacoes as $avaliacao) 
                @if($avaliacao->projeto_id == $projeto->id)
                    {{$avaliador->nome}}
                    <br>
                @endif
              @endforeach
            @endforeach    
            </td>
  				</tr>
  				@endforeach
  			</tbody>	
  
		</table> 
	</div>
</div>
@endsection

