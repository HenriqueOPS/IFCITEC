@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE COORIENTADORES DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC
        </h5>
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
            {{$cont = 0}}
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
            {{$cont++}}
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Coorientadores: {{$cont}}</b></p> 
        <br>
    </div>
</div>
@endsection