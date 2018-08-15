@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 5mm; margin-left: 5mm;">RELATÓRIO DE AUTORES, ORIENTADORES, COORIENTADORES,
        </h2>

        <h2 style="text-align: center;">
        VOLUNTÁRIOS, HOMOLOGADORES E AVALIADORES POR
        </h2>

        <h2 style="text-align: center;">
        EDIÇÃO
        </h2>
        <br>
        @foreach($edicoes as $edicao)
        @if($edicao->ano > 5)
        <p style="text-align: center;"><b> Edição {{\App\Edicao::numeroEdicao($edicao->ano)}}</b></p>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
        	<thead>
        		<tr>
    				<th>Autores</th>
  				</tr>
        	</thead>
  			<tbody>
  			<tr>
            <td>
            @foreach($autores as $autor)
            @if($autor->edicao_id == $edicao->id)
    				{{$autor->nome}}
            <br>
            <hr>
            @endif
            @endforeach
            </td> 
            </tr>		
  			</tbody>	
  
		  </table>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Orientadores</th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            @foreach($orientadores as $orientador)
            @if($orientador->edicao_id == $edicao->id)
                    {{$orientador->nome}}
            <br>
            <hr>
            @endif
            @endforeach
            </td> 
            </tr>       
            </tbody>    
  
          </table>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Coorientadores</th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            @foreach($coorientadores as $coorientador)
            @if($coorientador->edicao_id == $edicao->id)
                    {{$coorientador->nome}}
            <br>
            <hr>
            @endif
            @endforeach
            </td> 
            </tr>       
            </tbody>    
  
          </table>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Homologadores</th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            @foreach($homologadores as $homologador)
            @if($homologador->edicao_id == $edicao->id)
                    {{$homologador->nome}}
            <br>
            <hr>
            @endif
            @endforeach
            </td> 
            </tr>       
            </tbody>    
  
          </table>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Avaliadores</th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            @foreach($avaliadores as $avaliador)
            @if($avaliador->edicao_id == $edicao->id)
                    {{$avaliador->nome}}
            <br>
            <hr>
            @endif
            @endforeach
            </td> 
            </tr>       
            </tbody>    
  
          </table>
        <br>
        <table style="margin-right: 3pt; margin-left: 3pt; width:100%; border: 1pt solid black; ">
            <thead>
                <tr>
                    <th>Voluntários</th>
                </tr>
            </thead>
            <tbody>
            <tr>
            <td>
            @foreach($voluntarios as $voluntario)
            @if($voluntario->edicao_id == $edicao->id)
                    {{$voluntario->nome}}
            <br>
            <hr>
            @endif
            @endforeach
            </td> 
            </tr>       
            </tbody>    
  
          </table>
        <br>
        @endif
        @endforeach 
	</div>
</div>
@endsection