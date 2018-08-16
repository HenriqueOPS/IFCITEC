@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center;">RELATÓRIO DE EDIÇÕES</h2>
        <br>
        @foreach($edicoes as $edicao)
        @if($edicao->ano > 5)
        <p style="text-align: center;"><b> Edição {{\App\Edicao::numeroEdicao($edicao->ano)}}</b></p>
        <br>
        <table class="table" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
        <tr>
        <th>Período da Feira: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['feira_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['feira_fechamento'])) }}</td>
        </tr>

        <tr>
        <th>Período de Inscrições de Projetos: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['incricao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['inscricao_fechamento'])) }}</td>
        </tr>

        <tr>
        <th>Período de Homologação: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_fechamento'])) }}</td>
        </tr>
        
        <tr>
        <th>Período de Credenciamento: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['credenciamento_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['credenciamento_fechamento'])) }}</td>
        </tr>
        
        <tr>
        <th>Período de Avaliação: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_fechamento'])) }}</td>
        </tr>

        <tr>
        <th>Período de Inscrição de Voluntário: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['voluntario_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['voluntario_fechamento'])) }}</td>
        </tr>

        <tr>
        <th>Período de Inscrição de Comissão Avaliadora: </th>
        <td>{{ date('d/m/Y H:i:s', strtotime($edicao['comissao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['comissao_fechamento'])) }}</td>
        </tr>  

        <tr>
        <th>Níveis: </th>
        <td>
          @foreach(($edicao->niveis()->orderBy('nivel')->get()) as $nivel)  
              {{$nivel->nivel}}
              <br>
          @endforeach  
        </td>
        </tr>    

        <tr>
        <th>Áreas do Conhecimento: </th>
        <td>
          @foreach(($edicao->areas()->orderBy('area_conhecimento')->get()) as $area)  
              {{$area->area_conhecimento}}
              <br>
          @endforeach 
        </td>
        </tr>  
        </table>   
        <br>   
        @endif
        @endforeach
	</div>
</div>
@endsection

