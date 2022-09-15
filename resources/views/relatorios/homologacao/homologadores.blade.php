@extends('relatorios.relatorio')

@section('content')

<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE HOMOLOGADORES DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC</h5>
</header>

<div class="container">
    <div class="row">
        <br>
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Homologadores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
	    @php($cont = 0)
            @foreach($homologadores as $homologador)
            <tr>
            <td>
            <a style="color: #000;">{{$homologador->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$homologador->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$homologador->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$homologador->telefone}}</a>
            </td>  
	    @php($cont++)
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Homologadores: {{$cont}}</b></p> 
        <br>
    </div>
</div>
@endsection
