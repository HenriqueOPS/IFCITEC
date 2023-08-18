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
                        <th>Nivel</th>
                        <th>Nome</th>
                        <th>Num Projetos</th>
                    </tr>
                </thead>
                <tbody>

                @foreach ($rows as $row)
    <tr>
  
        <td>
            <a style="color: #000;">{{ $row->uf }}</a>
        </td>
        <td>
            <a style="color: #000;">{{ $row->municipio }}</a>
        </td>
        <td>
            <a style="color: #000;">{{ $row->nivel }}</a>
        </td>
        <td>
            <a style="color: #000;">{{ $row->nome_curto }}</a>
        </td>
        <td>
            <a style="color: #000;">{{ $row->contagem }}</a>
        </td>
    </tr>
@endforeach

       
@endsection

@section('css')
    <style>
        .tipo-header {
            text-align: center;
        }
    </style>
@endsection
