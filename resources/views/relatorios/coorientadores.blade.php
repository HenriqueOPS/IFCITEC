@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE COORIENTADORES DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC
        </h2>
</header>
<div class="container">
    <div class="row">
        <br>
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Coorientadores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
						@php($cont = 0)
            @foreach($coorientadores as $coorientador)
            <tr>
            <td>
            <a style="color: #000;">{{$coorientador->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$coorientador->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$coorientador->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$coorientador->telefone}}</a>
            </td>  
            @php($cont++)
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Coorientadores: {{$cont}}</b></p> 
        <br>
    </div>
</div>
@endsection
