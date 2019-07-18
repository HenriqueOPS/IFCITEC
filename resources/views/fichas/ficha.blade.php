@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">

        <div class="row">

            <div class="col-md-12 main main-raised">

                <div class="col-md-12 text-center">
                    <h2>Painel administrativo</h2>
                    <h3>Fichas</h3>
                </div>

                        <ul class="nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                            <li>
                                <a href="{{ route('mostraCat') }}">
                                    <i class="material-icons">list_alt</i>
                                    Categoria
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('listaCat') }}">
                                    <i class="material-icons">description</i>
                                    Critérios de Avaliação
                                </a>
                            </li>

                            {{--<li>--}}
                            {{--<a  href="{{ route('mostraItem') }}">--}}
                            {{--<i class="material-icons">list_alt</i>--}}
                            {{--Listar Itens--}}
                            {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            <li>
                                <a href="{{ route('telaEscolheTipo') }}">
                                    <i class="material-icons">description</i>
                                    Montar Formulário
                                </a>
                            </li>
                        </ul>
                    </div>
        </div>
    </div>






@endsection

@section('partials')


@endsection

@section('js')

@endsection
