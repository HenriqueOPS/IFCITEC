@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE VOLUNTÁRIOS DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC
        </h5>
        <br>
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
            {{$cont = 0}}
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
            {{$cont++}}
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Voluntários: {{$cont}}</b></p> 
        <br>
    </div>
</div>
@endsection