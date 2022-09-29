@extends('relatorios.relatorio')

@section('content')
    <header>
        <img src="{{ asset('img/ifcitecheader.png') }}" />
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE ORIENTADORES DA
            {{ \App\Edicao::numeroEdicao($edicao) }} IFCITEC (PÓS HOMOLOGAÇÃO)
        </h2>
    </header>
    <div class="container">
        <div class="row">
            <br>
            <table class="bordered striped centered" style="width:100%;">
                <thead>
                    <tr>
                        <th>Orientadores</th>
                        <th>RG</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    @php($cont = 0)
                    @foreach ($orientadores as $orientador)
                        <tr>
                            <td>
                                <a style="color: #000;">{{ $orientador->nome }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $orientador->rg }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $orientador->cpf }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $orientador->telefone }}</a>
                            </td>
                            @php($cont++)
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><b> Total de Orientadores: {{ $cont }}</b></p>
            <br>
        </div>
    </div>
@endsection
