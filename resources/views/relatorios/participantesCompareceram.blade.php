@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE AUTORES, COORIENTADORES, ORIENTADORES E VOLUNTÁRIOS QUE COMPARECERAM NA IFCITEC
        </h5>
        <br>
        <table class="bordered striped centered" style="width:100%;">
        	<thead>
        		<tr>
    				<th>Autores</th>
  				</tr>
        	</thead>
  			<tbody>
            {{$cont = 0}}
            @foreach($autores as $autor)
            <tr>
            <td>
    		<a style="color: #000;">{{$autor->nome}}</a>
            </td>  
            {{$cont++}}
             </tr>  
            @endforeach	
  			</tbody>	
		  </table>
          <p><b> Total de Autores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Coorientadores</th>
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($coorientadores as $coorientador)
            <tr>
            <td>
            <a style="color: #000;">{{$coorientador->nome}}</a>
            </td>  
            {{$cont++}}
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Coorientadores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Orientadores</th>
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($orientadores as $orientador)
            <tr>
            <td>
            <a style="color: #000;">{{$orientador->nome}}</a>
            </td>  
            {{$cont++}}
             </tr>  
            @endforeach 
            </tbody>    
          </table>
          <p><b> Total de Orientadores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="width:100%;">
            <thead>
                <tr>
                    <th>Voluntários</th>
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($voluntarios as $voluntario)
            <tr>
            <td>
            <a style="color: #000;">{{$voluntario->nome}}</a>
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