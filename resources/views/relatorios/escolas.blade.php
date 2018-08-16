@extends('relatorios.relatorio')


@section('content')
        <h2 style=" margin-left: 250px;">RELATÓRIO DE ESCOLAS</h2>

        <br>
        @foreach($escolas as $escola)
        <p style="text-align: center;"><b>{{$escola->nome_curto}}</b></p>
        <table id="hor-minimalist-a"  style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
          <tr>
              <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">Município: </th>
              <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
                {{$escola->municipio}}
              </td>
           </tr>

           <tr>
              <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">Email: </th>
              <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">{{$escola->email}}</td>
           </tr>

           <tr>
              <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">Telefone: </th>
              <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">{{$escola->telefone}}</td>
           </tr>

           <tr>
              <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">CEP: </th>
              <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
                {{$escola->cep}}
              </td>
           </tr>

           <tr>
              <th style="margin-left: 3pt; border-bottom:solid 1pt #000;">Endereço: </th>
              <td style="margin-left: 3pt; border-bottom:solid 1pt #000;">
                {{$escola->endereco}}, {{$escola->numero}}
              </td>
           </tr>
        	<br>
		  </table> 
      @endforeach
@endsection
