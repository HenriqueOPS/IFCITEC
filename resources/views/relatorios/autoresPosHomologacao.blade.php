@extends('relatorios.relatorio')

@section('content')
<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
    <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE AUTORES DA {{\App\Edicao::numeroEdicao($edicao)}} IFCITEC (PÓS HOMOLOGAÇÃO)</h2>
</header>
<div class="container">
    <div class="row">
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
            @php($cont = 0)
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
            @php($cont++)
             </tr>  
            @endforeach	
  			</tbody>	
		  </table>
          <p><b> Total de Autores: {{$cont}}</b></p> 
        <br>
	</div>
</div>
@endsection