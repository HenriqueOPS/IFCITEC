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
  				</tr>
        	</thead>
  			<tbody>
            {{$cont = 0}}
            @foreach($autores as $autor)
            @if($autor->edicao_id == $edicao->id)
            <tr>
            <td>
    		{{$autor->nome}}
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
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($orientadores as $orientador)
            @if($orientador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$orientador->nome}}
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
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($coorientadores as $coorientador)
            @if($coorientador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$coorientador->nome}}
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
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($homologadores as $homologador)
            @if($homologador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$homologador->nome}}
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
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($avaliadores as $avaliador)
            @if($avaliador->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$avaliador->nome}}
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
                </tr>
            </thead>
            <tbody>
            {{$cont = 0}}
            @foreach($voluntarios as $voluntario)
            @if($voluntario->edicao_id == $edicao->id)
            <tr>
            <td>
                    {{$voluntario->nome}}
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