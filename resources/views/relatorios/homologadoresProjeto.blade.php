@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center;">RELATÓRIO DE HOMOLOGADORES POR PROJETO</h2>

        @foreach($projetos as $projeto)
        <p style="text-align: center; margin-top: 5mm;"><b>{{$projeto->titulo}}</b></p>
        <br>
        <table style="width: 100%; border: 1pt solid black;">
          <tr>
          <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">Homologadores: </th>
          <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
              @foreach($homologadores as $homologador)
              @foreach($revisoes as $revisao) 
                @if($revisao->projeto_id == $projeto->id && $homologador->id == $revisao->pessoa_id)
                    {{$homologador->nome}}
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

