@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h5 style="text-align: center;">RELATÓRIO DE AUTORES, ORIENTADORES, COORIENTADORES, VOLUNTÁRIOS, HOMOLOGADORES E AVALIADORES POR EDIÇÃO
        </h5>
        <br>
        @foreach($edicoes as $edicao)
        @if($edicao->ano > 5)
        <p style="text-align: center;"><b> Edição {{\App\Edicao::numeroEdicao($edicao->ano)}}</b></p>
        <br>
        <table class="table" style="margin-right: 3mm; margin-left: 3mm; width:100%;">
        	<thead>
        		<tr>
    				<th>Autores</th>
  				</tr>
        	</thead>
  			<tbody>
            @foreach($autores as $autor)
            @if($autor->edicao_id == $edicao->id)
            <tr>
            <td>
    		{{$autor->nome}}
            </td> 
             </tr>  
            @endif
            @endforeach	
  			</tbody>	
  
		  </table>
        <br>
        <table class="table" style="margin-top:3pt; margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Orientadores</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orientadores as $orientador)
            @if($orientador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$orientador->nome}}
            </td> 
            </tr> 
            @endif
            @endforeach      
            </tbody>    
  
          </table>
        <br>
        <table class="table" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Coorientadores</th>
                </tr>
            </thead>
            <tbody>
            @foreach($coorientadores as $coorientador)
            @if($coorientador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$coorientador->nome}}
            </td> 
            </tr>
            @endif
            @endforeach       
            </tbody>    
  
          </table>
        <br>
        <table class="table" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Homologadores</th>
                </tr>
            </thead>
            <tbody>
            @foreach($homologadores as $homologador)
            @if($homologador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$homologador->nome}}
            </td> 
            </tr>  
            @endif
            @endforeach     
            </tbody>    
  
          </table>
        <br>
        <table class="table" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Avaliadores</th>
                </tr>
            </thead>
            <tbody>
            @foreach($avaliadores as $avaliador)
            @if($avaliador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$avaliador->nome}}
            </td> 
            </tr>  
            @endif
            @endforeach     
            </tbody>    
  
          </table>
        <br>
        <table class="table" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
            <thead>
                <tr>
                    <th>Voluntários</th>
                </tr>
            </thead>
            <tbody>
            @foreach($voluntarios as $voluntario)
            @if($voluntario->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$voluntario->nome}}
            </td> 
            </tr> 
            @endif
            @endforeach      
            </tbody>    
  
          </table>
        <br>
        @endif
        @endforeach 
	</div>
</div>
@endsection