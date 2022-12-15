@extends('relatorios.relatorio')

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS DA ESCOLA
                    <br>{{ $escola->nome_curto }}
                </h2>
            </div>

            <div>
                <h5 style="font-size: 20px; margin-bottom: 20pt;">Numero total de projetos: {{ $numeroProjetos }}</h5>
            </div>

            <div>
                @foreach ($situacoes as $situacao)
                    @php($cont = 0)
                    <table class="bordered striped centered" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Título</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projetos as $projeto)
                                @if ($projeto->situacao == $situacao->situacao)
                                    @php($cont += 1)
                                    <tr>
                                        <td><a style="color: #000;">{{ $cont }}</a></td>
                                        <td><a style="color: #000;">{{ $projeto->titulo }}</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <h5 style="font-size: 20px; margin-bottom: 25pt;">Numero de {{ $situacao->situacao }}:
                        {{ $cont }}</h5>
                @endforeach
            </div>
        </div>
    </div>
@endsection
