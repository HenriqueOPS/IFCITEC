@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE AVALIADORES DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC
        </h2>
</header>
<div class="container">
    <div class="row">
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Avaliadores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
						@php($cont = 0)
            @foreach($avaliadores as $avaliador)
            <tr>
            <td>
            <a style="color: #000;">{{$avaliador->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$avaliador->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$avaliador->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$avaliador->telefone}}</a>
            </td>  
						@php($cont++)
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Avaliadores: {{$cont}}</b></p> 
        <br>
    </div>
</div>
@endsection
