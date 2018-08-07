@extends('relatorios.relatorio')
@section('css')
@section('content')
<div class="container">
    <div class="row">
        <h2 style="margin-top: 1mm; margin-left: 70mm;">RELATÓRIO DE EDIÇÕES</h2>
        <br>
        @foreach($edicoes as $edicao)
        <p style="text-align: center;"><b> Edição {{\App\Edicao::numeroEdicao($edicao->ano)}}</b></p>
        <br>
        <table style="margin-right: 3mm; margin-left: 3mm; width:100%; border: 1mm solid black; ">
        <tr>
        <th style="margin-right: 5mm; margin-left: 10mm; border-bottom:solid 1mm #000;">Período da Feira: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['feira_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['feira_fechamento'])) }}</td>
        </tr>

        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Período de Inscrições de Projetos: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['incricao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['inscricao_fechamento'])) }}</td>
        </tr>

        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Período de Homologação: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['homologacao_fechamento'])) }}</td>
        </tr>
        
        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Período de Credenciamento: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['credenciamento_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['credenciamento_fechamento'])) }}</td>
        </tr>
        
        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Período de Avaliação: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['avaliacao_fechamento'])) }}</td>
        </tr>

        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Período de Inscrição de Voluntário: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['voluntario_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['voluntario_fechamento'])) }}</td>
        </tr>

        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Período de Inscrição de Comissão Avaliadora: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">{{ date('d/m/Y H:i:s', strtotime($edicao['comissao_abertura'])) }} - {{ date('d/m/Y H:i:s', strtotime($edicao['comissao_fechamento'])) }}</td>
        </tr>  

        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Níveis: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">
          @foreach(($edicao->niveis()->orderBy('nivel')->get()) as $nivel)  
              {{$nivel->nivel}}
              <br>
          @endforeach  
        </td>
        </tr>    

        <tr>
        <th style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">Áreas do Conhecimento: </th>
        <td style="margin-right: 5mm; margin-left: 5mm; border-bottom:solid 1mm #000;">
          @foreach(($edicao->areas()->orderBy('area_conhecimento')->get()) as $area)  
              {{$area->area_conhecimento}}
              <br>
          @endforeach 
        </td>
        </tr>  
        </table>   
        <br>   
        @endforeach
	</div>
</div>
@endsection

