@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE AUTORES DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC (PÓS HOMOLOGAÇÃO)
        </h5>
        <br>
        <table class="bordered striped centered" style="width:100%;">
        	<thead>
        		<tr>
    				<th>Autores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
  				</tr>
        	</thead>
  			<tbody>
            {{$cont = 0}}
            @foreach($autores as $autor)
            <tr>
            <td>
    		<a style="color: #000;">{{$autor->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$autor->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$autor->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$autor->telefone}}</a>
            </td>  
            {{$cont++}}
             </tr>  
            @endforeach	
  			</tbody>	
		  </table>
          <p><b> Total de Autores: {{$cont}}</b></p> 
        <br>
	</div>
</div>
@endsection