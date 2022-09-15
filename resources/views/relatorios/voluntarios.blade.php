@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE VOLUNTÁRIOS DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC
        </h2>
</header>
<div class="container">
    <div class="row">
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Voluntários</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
						@php($cont = 0)
            @foreach($voluntarios as $voluntario)
            <tr>
            <td>
            <a style="color: #000;">{{$voluntario->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$voluntario->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$voluntario->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$voluntario->telefone}}</a>
            </td>  
						@php($cont++)
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Voluntários: {{$cont}}</b></p> 
        <br>
    </div>
</div>
@endsection
