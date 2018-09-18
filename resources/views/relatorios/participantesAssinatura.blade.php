@extends('relatorios.relatorioPaisagem')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE ASSINATURAS
        </h5>
        <br>
        <table class="bordered striped centered" style="width:100%;">
        	<thead>
        		<tr>
    				<th>Autores</th>
                    <th>Assinatura</th>
  				</tr>
        	</thead>
  			<tbody>
            @foreach($autores as $autor)
            <tr>
            <td>
    		<a style="color: #000;">{{$autor->nome}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach	
  			</tbody>	
		  </table>
        <br>
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Orientadores</th>
                    <th>Assinatura</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orientadores as $orientador)
            <tr>
            <td>
            <a style="color: #000;">{{$orientador->nome}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach 
            </tbody>    
          </table>
          <br>
          <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Coorientadores</th>
                    <th>Assinatura</th>
                </tr>
            </thead>
            <tbody>
            @foreach($coorientadores as $coorientador)
            <tr>
            <td>
            <a style="color: #000;">{{$coorientador->nome}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach 
            </tbody>    
          </table>
	</div>
</div>
@endsection