@extends('relatorios.relatorio')


@section('content')
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE ESCOLAS</h2>

        <br>
        @foreach($escolas as $escola)
        <p style="text-align: center; text-transform: uppercase;"><b>{{$escola->nome_curto}}</b></p>
        <table class="bordered striped centered"  style="width:100%;">
          <tr>
              <th>Email: </th>
              <td>{{$escola->email}}</td>
          </tr>

          <tr>
              <th>Telefone: </th>
              <td>{{$escola->telefone}}</td>
          </tr>

          <tr>
              <th>Endereço: </th>
              <td>
                {{$escola->endereco}}, {{$escola->numero}}
              </td>
           </tr>

          <tr>
              <th>Município: </th>
              <td>
                {{$escola->municipio}}
              </td>
           </tr>

           <tr>
              <th>Estado: </th>
              <td>
                {{$escola->uf}}
              </td>
           </tr>

           <tr>
              <th>CEP: </th>
              <td>
                {{$escola->cep}}
              </td>
           </tr>
        	<br>
		  </table> 
      @endforeach
@endsection
