@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center; font-size: 25px;">RELATÓRIO DE AUTORES, ORIENTADORES, COORIENTADORES, VOLUNTÁRIOS, HOMOLOGADORES E AVALIADORES POR EDIÇÃO
        </h5>
        <br>
        @foreach($edicoes as $edicao)
        @if($edicao->ano > 5)
        <p style="text-align: center;"><b> Edição {{\App\Edicao::numeroEdicao($edicao->ano)}}</b></p>
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
            @if($autor->edicao_id == $edicao->id)
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
            @endif
            @endforeach	
  			</tbody>	
		  </table>
          <p><b> Total de Autores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="margin-top:3pt; margin-right: 3pt; margin-left: 3pt; width:100%;">
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
            @if($orientador->edicao_id == $edicao->id)
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
            @endif
            @endforeach      
            </tbody> 
          </table>
          <p><b> Total de Orientadores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
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
            @if($coorientador->edicao_id == $edicao->id)
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
            @endif
            @endforeach       
            </tbody>    
          </table>
          <p><b> Total de Coorientadores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Homologadores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($homologadores as $homologador)
            @if($homologador->edicao_id == $edicao->id)
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
            {{$cont++}}
            </tr>  
            @endif
            @endforeach     
            </tbody>    
          </table>
           <p><b> Total de Homologadores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Avaliadores</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($avaliadores as $avaliador)
            @if($avaliador->edicao_id == $edicao->id)
            <tr>
            <td>
                    <a style="color: #000;">{{$avaliador->nome}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$avaliador->rg}}</a>
            </td> 
            <td>
            <a style="color: #000;">{{$avaliador->cpf}}</a>
            </td>
            <td>
            <a style="color: #000;">{{$avaliador->telefone}}</a>
            </td>  
            {{$cont++}}
            </tr>  
            @endif
            @endforeach     
            </tbody>    
          </table>
          <p><b> Total de Avaliadores: {{$cont}}</b></p> 
        <br>
        <table class="bordered striped centered" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
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
            @if($voluntario->edicao_id == $edicao->id)
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
            @endif
            @endforeach      
            </tbody>    
          </table>
          <p><b> Total de Voluntários: {{$cont}}</b></p> 
        <br>
        @endif
        @endforeach 
	</div>
</div>
@endsection