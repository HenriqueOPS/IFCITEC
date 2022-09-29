@extends('relatorios.relatorio')

@section('content')
    <header>
        <img src="{{ asset('img/ifcitecheader.png') }}" />
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE TAMANHO DE CAMISAS DOS AUTORES
        </h2>
    </header>
    <div class="container">
        <div class="row">
            <br>
            <table class="bordered striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Autores</th>
                        <th>Tamanho</th>
                        <th>Assinatura</th>
                    </tr>
                </thead>
                <tbody>
                    @php($camisaP = 0)
                    @php($camisaM = 0)
                    @php($camisaG = 0)
                    @php($camisaGG = 0)
                    @php($camisaXG = 0)

                    @foreach ($autores as $autor)
                        <tr>
                            <td style="width: 50%">
                                <a style="color: #000;">{{ $autor->nome }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $autor->camisa }}</a>
                            </td>
                            <td></td>
                        </tr>
                        @if ($autor->camisa == "P")
                            @php($camisaP++)
                        @elseif ($autor->camisa == "M")
                            @php($camisaM++)
                        @elseif ($autor->camisa == "G")
                            @php($camisaG++)
                        @elseif ($autor->camisa == "GG")
                            @php($camisaGG++)
                        @elseif ($autor->camisa == "XG")
                            @php($camisaXG++)
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br>
            <table class="bordered striped">
                <tr>
                    <td>Camisas P: {{ $camisaP }}</td>
                    <td>Camisas M: {{ $camisaM }}</td>
                    <td>Camisas G: {{ $camisaG }}</td>
                    <td>Camisas GG: {{ $camisaGG }}</td>
                    <td>Camisas XG: {{ $camisaXG }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
