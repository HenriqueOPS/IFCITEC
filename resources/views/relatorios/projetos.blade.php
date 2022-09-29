@extends('relatorios.relatorio')

@section('content')
    <style>
        body {
            background-image: unset;
        }

        @media print {
            body {
                padding-top: 0mm;
                margin: 0pt;
            }

            @page {
                margin: 10mm 0mm 0mm 0mm;
                padding-top: 10mm;
            }

            header {
                page-break-before: auto;
                /* 'always,' 'avoid,' 'left,' 'inherit,' or 'right' */
                page-break-after: auto;
                /* 'always,' 'avoid,' 'left,' 'inherit,' or 'right' */
                page-break-inside: avoid;
                /* or 'auto' */
                ;
                top: 0;
                width: 98%;
                overflow: hidden;
            }

            header>img {
                width: 100%;
            }

            header>h2 {
                margin-top: -1pt;
            }

            table {
                page-break-inside: auto
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
                font-size: 10pt !important;
                width: 100%;
            }
        }
    </style>

    <header>
        <img src="{{ asset('img/ifcitecheader.png') }}" />
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO DE PROJETOS</h2>
    </header>

    <div class="table-wrapper container">
        <div class="row">

            @foreach ($situacoes as $situacao)
				<br>
                <h4 class="row" style="text-align: center">{{ $situacao['name'] }}</h4>
				<br>
                <table class="bordered striped centered" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Projeto</th>
                            <th>Escola</th>
                            <th>Autor(es)</th>
                            <th>Orientador</th>
                            <th>Coorientador(es)</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($situacao["projetos"] as $projeto)
                            <tr>
                                <td>{{ $projeto->titulo }}</td>
                                <td>{{ \App\Escola::find($projeto->escola_id)->nome_curto }}</td>
                                <td>
                                    @foreach ($projeto->getAutores() as $autor)
                                        <a style="color: #000;">{{ $autor->nome }}</a>
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($projeto->getOrientador() as $orientador)
                                        <a style="color: #000;">{{ $orientador->nome }}</a>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($projeto->getCoorientadores() as $coorientador)
                                        <a style="color: #000;">{{ $coorientador->nome }}</a>
                                        <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
				<h5 class="row striped centered" style="text-align: center">Total de {{$situacao["name"]}}: {{$situacao["total"]}}</h5>
            @endforeach
        </div>
    </div>
@endsection
