@extends('relatorios.relatorio')

@section('content')

<header>
	<img src="{{ asset('img/ifcitecheader.png')  }}"/>
	<h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE ASSINATURAS PARTCIPANTES</h2>
	<h4 style="text-align: center; font-size: 25px;">{{\App\Edicao::numeroEdicao($edicao)}} Edição</h4>
</header>

<div class="container">
    <div class="row">
        <table class="bordered striped" style="width:100%;">
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
    		<a style="color: #000; text-align: left;">{{$autor->nome}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach	
  			</tbody>	
		  </table>
        <br>
        <table class="bordered striped" style="width:100%;">
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
            <a style="color: #000; text-align: left;">{{$orientador->nome}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach 
            </tbody>    
          </table>
          <br>
          <table class="bordered striped" style="width:100%;">
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
            <a style="color: #000; text-align: left;">{{$coorientador->nome}}</a>
            </td> 
            <td>
            
            </td> 
            @endforeach 
            </tbody>    
          </table>
	</div>
</div>
@endsection