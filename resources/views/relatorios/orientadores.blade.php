@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE ORIENTADORES DA {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC
        </h5>
        <br>
        <table class="bordered striped centered" style="width:100%;">
        	<thead>
        		<tr>
    				<th>Orientadores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
  				</tr>
        	</thead>
  			<tbody>
            {{$cont = 0}}
            @foreach($orientadores as $orientador)
            <tr>
            <td>
    		<a style="color: #000;">{{$orientador->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$orientador->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$orientador->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$orientador->telefone}}</a>
            </td>  
            {{$cont++}}
             </tr>  
            @endforeach	
  			</tbody>	
		  </table>
          <p><b> Total de Orientadores: {{$cont}}</b></p> 
        <br>
	</div>
</div>
@endsection