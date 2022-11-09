@extends('relatorios.relatorio')

@section('content')
    <header>
        <img src="{{ asset('img/ifcitecheader.png') }}" />
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE CONCLUINTES POR PROJETO
        </h2>
    </header>
    <div class="container">
        <div class="row">
            <br>
            <table class="bordered striped centered" style="width:100%;">
                <thead>
                    <tr>
                        <th>Projeto</th>
                        <th>Concluintes</th>
                    </tr>
                </thead>
                <tbody>
                    @php($cont = 0)
                    @foreach ($dados as $dado)
                        <tr>
                            <td>
                                <a style="color: #000;">{{ $dado['projeto'] }}</a>
                            </td>
                            @foreach ($dado['concluintes'] as $concluinte)
                                <td>
                                    <a style="color: #000;">{{ $concluinte->nome }}</a>
                                    <a style="color: #000;">{{ $concluinte->email }}</a>
                                </td>
                                @php($cont++)
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><b> Total de Concluintes: {{ $cont }}</b></p>
            <br>
        </div>
    </div>
@endsection
