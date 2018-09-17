@extends('relatorios.relatorio')

@section('content')
<div class="container">
    <div class="row">
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE EDIÇÕES</h2>
        <br>
        @foreach($edicoes as $edicao)
        @if($edicao->ano > 5)
        <p style="text-align: center;"><b> Edição {{\App\Edicao::numeroEdicao($edicao->ano)}}</b></p>
        <br>
        <table class="bordered striped centered" style="margin-right: 3pt; margin-left: 3pt; width:100%;">
        <tr>
        <th>Período da Feira: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['feira_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['feira_fechamento'])) }}</a></td>
        </tr>

        <tr>
        <th>Período de Inscrições de Projetos: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['inscricao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['inscricao_fechamento'])) }}</a></td>
        </tr>

        <tr>
        <th>Período de Homologação: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_fechamento'])) }}</a></td>
        </tr>
        
        <tr>
        <th>Período de Credenciamento: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['credenciamento_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['credenciamento_fechamento'])) }}</a></td>
        </tr>
        
        <tr>
        <th>Período de Avaliação: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_fechamento'])) }}</a></td>
        </tr>

        <tr>
        <th>Período de Inscrição de Voluntário: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['voluntario_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['voluntario_fechamento'])) }}</a></td>
        </tr>

        <tr>
        <th>Período de Inscrição de Comissão Avaliadora: </th>
        <td><a style="color: #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['comissao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['comissao_fechamento'])) }}</a></td>
        </tr>  

        <tr>
        <th>Níveis: </th>
        <td>
          @foreach(($edicao->niveis()->orderBy('nivel')->get()) as $nivel)  
              <a style="color: #000;">{{$nivel->nivel}}</a>
              <br>
          @endforeach  
        </td>
        </tr>    

        <tr>
        <th>Áreas do Conhecimento: </th>
        <td>
          @foreach(($edicao->areas()->orderBy('area_conhecimento')->get()) as $area)  
              <a style="color: #000;">{{$area->area_conhecimento}}</a>
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

