@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center;">RELATÓRIO DE AVALIADORES POR PROJETO</h2>

        @foreach($projetos as $projeto)
        <p style="text-align: center; margin-top: 5mm;"><b>{{$projeto->titulo}}</b></p>
        <br>
        <table style="width: 100%; border: 1pt solid black;">
          <tr>
          <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">Avaliadores: </th>
          <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
              @foreach($avaliadores as $avaliador)
              @foreach($avaliacoes as $avaliacao) 
                @if($avaliacao->projeto_id == $projeto->id && $avaliador->id == $avaliacao->pessoa_id)
                    {{$avaliador->nome}}
                    <br>
                @endif
              @endforeach
              @endforeach  
          </td>
          </tr>
		    </table>
        <br>
        @endforeach
	</div>
</div>
@endsection

