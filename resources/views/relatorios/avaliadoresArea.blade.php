@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE AVALIADORES POR ÁREA</h2>

        <br>
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
          {{$cont = 0}}
          @foreach($avaliadores as $avaliador)
          @if($area->id == $avaliador->area_id)
          <tr>
            <td><a style="color: #000;">{{$avaliador->nome}}</a></td>
            {{$cont++}}
          </tr>
          @endif
          @endforeach
        </tbody>  
        </table> 
        <p><b> Total de Avaliadores: {{$cont}}</b></p>  
        <br>   
        @endforeach
	</div>
</div>
@endsection

