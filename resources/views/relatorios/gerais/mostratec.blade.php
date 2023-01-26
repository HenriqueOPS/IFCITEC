@extends('relatorios.relatorio')

@section('content')
    <header>
        <img src="{{ asset('img/ifcitecheader.png') }}" />
        <h2 style="text-align: center; font-size: 25px;">RELATÓRIO MOSTRATEC</h2>
    </header>

    <div class="container">
        <div class="row">
            <p style="text-align: center;">
                <b>Escolas Publicas</b>
            </p>

            <table class="bordered striped centered" style="width:100%;">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CEP</th>
                        <th>Endereco</th>
                        <th>Bairro</th>
                        <th>Estado</th>
                        <th>Numero</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($escolasPublicas as $escola)
                        <tr>
                            <td>
                                <a style="color: #000;">{{ $escola->nome_completo }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->email }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->telefone }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->cep }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->endereco }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->bairro }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->uf }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->numero }}</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <p>
                <b>Total de escola publicas: {{ count($escolasPublicas) }}</b>
            </p>
            <br>
            <p style="text-align: center;">
                <b>Escolas Privadas</b>
            </p>

            <table class="bordered striped centered" style="width:100%;">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CEP</th>
                        <th>Endereco</th>
                        <th>Bairro</th>
                        <th>Estado</th>
                        <th>Numero</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($escolasPrivadas as $escola)
                        <tr>
                            <td>
                                <a style="color: #000;">{{ $escola->nome_completo }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->email }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->telefone }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->cep }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->endereco }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->bairro }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->uf }}</a>
                            </td>
                            <td>
                                <a style="color: #000;">{{ $escola->numero }}</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <p>
                <b>Total de escola privadas: {{ count($escolasPrivadas) }}</b>
            </p>
            <br>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .tipo-header {
            text-align: center;
        }
    </style>
@endsection
