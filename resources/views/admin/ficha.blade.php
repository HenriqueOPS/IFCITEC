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
                                <a href="{{ route('cadastroCategoria') }}">
                                    <i class="material-icons">description</i>
                                    Adicionar Categoria
                                </a>
                            </li>

                            <li>
                                <a  href="{{ route('cadastroCampo') }}" >
                                    <i class="material-icons">description</i>
                                   Adicionar Item
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('mostraCat') }}">
                                    <i class="material-icons">list_alt</i>
                                    Listar Categorias
                                </a>
                            </li>
                            <li>
                                <a  href="{{ route('mostraItem') }}">
                                    <i class="material-icons">list_alt</i>
                                    Listar Itens
                                </a>
                            </li>
                            <li>
                                <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Montar Ficha
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

