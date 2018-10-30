@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS QUE COMPARECERÃO NA IFCITEC (ÁREA DO CONHECIMENTO)</h2>

        <br>
        @foreach($areas as $area)
        <p style="text-align: center;"><b> {{$area->niveis->nivel}} : {{$area->area_conhecimento}}</b></p>
        <br>
        <table class="bordered striped centered" style="width:100%;">
          <thead>
            <tr>
              <th>Título</th>
              <th>Escola</th>
            </tr>
          </thead>
        <tbody>
          {{$projetos = $area->getProjetos($area->id, $edicao)}}
          @foreach($projetos as $projeto)
            <tr>
              <td><a style="color: #000;">{{$projeto->titulo}}</a></td>
              <td><a style="color: #000;">{{$projeto->nome_curto}}</a></td>
            </tr>
          @endforeach
        </tbody>  
        </table>    
        <br>   
        @endforeach
	</div>
</div>
@endsection

