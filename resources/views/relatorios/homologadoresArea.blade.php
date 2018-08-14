@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center;">RELATÓRIO DE HOMOLOGADORES POR ÁREA</h2>

        <br>
        @foreach($areas as $area)
        <p style="text-align: center;"><b> {{$area->area_conhecimento}}</b></p>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
          <thead>
            <tr>
              <th>Nome</th>
            </tr>
          </thead>
        <tbody>
          @foreach($homologadores as $homologador)
          @if($area->id == $homologador->area_id)
          <tr>
            <td>{{$homologador->nome}}</td>
          </tr>
          @endif
          @endforeach
        </tbody>  
        </table>   
        <br>   
        @endforeach
	</div>
</div>
@endsection

