@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center;">RELATÓRIO DE HOMOLOGADORES POR PROJETO</h2>

        <table style="margin-left: 25mm; margin-top: 10mm; width: 100%;">
        	<thead>
        		<tr>
    				<th>Projeto</th>
            <th>Homologadores</th>
  				</tr>
        	</thead>
  			<tbody>
  				@foreach($projetos as $projeto)
  				<tr>
    				<td style="border-bottom:solid 1px #000;">{{$projeto->titulo}}</td>
    				<td style="border-bottom:solid 1px #000;">
            @foreach($homologadores as $homologador)
              @foreach($homologador->revisoes as $revisao) 
                @if($revisao->projeto_id == $projeto->id)
                    {{$homologador->nome}}
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

