@extends('relatorios.relatorio')

@section('content')
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE ESCOLAS</h2>

        <br>
        @foreach($escolas as $escola)
        <p style="text-align: center; text-transform: uppercase;">
			<b>{{$escola->nome_curto}}</b>
		</p>

		<table class="bordered striped centered"  style="width:100%;">
			<tr>
			  <th>Email: </th>
			  <td><a style="color: #000;">{{$escola->email}}</a></td>
			</tr>

			<tr>
			  <th>Telefone: </th>
			  <td><a style="color: #000;">{{$escola->telefone}}</a></td>
			</tr>

			<tr>
			  <th>Endereço: </th>
			  <td>
				<a style="color: #000;">{{$escola->endereco}}, {{$escola->numero}}</a>
			  </td>
			</tr>

			<tr>
			  <th>Município: </th>
			  <td>
				<a style="color: #000;">{{$escola->municipio}}</a>
			  </td>
			</tr>

			<tr>
			  <th>Estado: </th>
			  <td>
				<a style="color: #000;">{{$escola->uf}}</a>
			  </td>
			</tr>

			<tr>
			  <th>CEP: </th>
			  <td>
				<a style="color: #000;">{{$escola->cep}}</a>
			  </td>
			</tr>
		</table>
      @endforeach
@endsection
