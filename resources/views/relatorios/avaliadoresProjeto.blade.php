@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE AVALIADORES POR PROJETO</h2>

        @foreach($projetos as $projeto)
        <table class="bordered striped centered" style="width: 100%;">
          <thead>
            <tr>
              <th>{{$projeto->titulo}}</th> 
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                  <a style="color: #000;">Avaliadores: </a>
                  @foreach($projeto->avaliacoes as $avaliacao)
                        <a style="color: #000;">{{$avaliacao->pessoa->nome}}, </a>
                  @endforeach  
              </td>
            </tr>
          </tbody>
		    </table>
        <br>
        @endforeach
	</div>
</div>
@endsection

