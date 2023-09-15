@extends('relatorios.relatorio')

@section('content')
    <header>
        <img src="{{ asset('img/ifcitecheader.png') }}" />
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE ESCOLAS PARTICIPANTES</h2>
    </header>
    <table class="bordered striped centered" style="width:100%;">
        <thead>
            <tr>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Nível</th>
                <th>Nome</th>
                <th>Número de Projetos</th>
            </tr>
        </thead>
        <tbody>
            @php
                $cidadesPorEstado = [];
                $totalProjetos = 0;
            @endphp

            @foreach ($rows as $row)
                <tr>
                    <td><a style="color: #000;">{{ $row->uf }}</a></td>
                    <td><a style="color: #000;">{{ $row->municipio }}</a></td>
                    <td><a style="color: #000;">{{ $row->nivel }}</a></td>
                    <td><a style="color: #000;">{{ $row->nome_curto }}</a></td>
                    <td><a style="color: #000;">{{ $row->contagem }}</a></td>
                </tr>
                @php
                    $estado = $row->uf;
                    $cidade = $row->municipio;

                    if (!isset($cidadesPorEstado[$estado])) {
                        $cidadesPorEstado[$estado] = [];
                    }

                    if (!in_array($cidade, $cidadesPorEstado[$estado])) {
                        $cidadesPorEstado[$estado][] = $cidade;
                    }

                    $totalProjetos += $row->contagem; // Adiciona o número de projetos ao total
                @endphp
            @endforeach

            {{-- Exibir a contagem de cidades diferentes por estado --}}
            @foreach ($cidadesPorEstado as $estado => $cidades)
                <tr>
                    <td><strong></strong></td> {{-- Deixe esta célula vazia para não exibir o nível --}}
                    <td><strong></strong></td> {{-- Deixe esta célula vazia para não exibir o nome --}}
                    <td><strong></strong></td> {{-- Deixe esta célula vazia para não exibir o número de projetos --}}
                    <td  style="text-align: right;"><strong>{{ $estado }}:</strong></td>
                    <td><strong>{{ count($cidades) }}</strong></td>
                </tr>
            @endforeach

            {{-- Exibir a linha com o número total de projetos --}}
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Total de Projetos:</strong></td>
                <td><strong>{{ $totalProjetos }}</strong></td>
            </tr>
        </tbody>
    </table>
@endsection

@section('css')
    <style>
        .tipo-header {
            text-align: center;
        }
    </style>
@endsection
