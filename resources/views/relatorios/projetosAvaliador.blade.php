@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS POR AVALIADOR</h2>

        @foreach($avaliadores as $avaliador)
        <table class="bordered striped centered" style="width: 100%;">
          <thead>
            <tr>
              <th>{{$avaliador->nome}}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
				  @foreach($avaliador->getProjetosAvaliador($avaliador->id) as $projeto)
				  <p style="color: #000;">{{$projeto->titulo}}</p>
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
