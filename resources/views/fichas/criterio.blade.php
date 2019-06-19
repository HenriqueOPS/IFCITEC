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

                    <li  >
                        <a href="{{ route('mostraCat') }}">
                            <i class="material-icons">list_alt</i>
                            Categoria
                        </a>
                    </li>
                    <li class="active">
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
                    <li>
                        <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                            <i class="material-icons">description</i>
                            Montar Ficha
                        </a>
                    </li>
                </ul>

                <table class="table">

                    <tr>

                        <th class="text-center">#</th>
                        <th>Categoria</th>
                        <th>Peso</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="1">
                    @foreach($cat as $i => $cats)

                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $cats['descricao'] }}</td>
                            <td>{{ $cats['peso'] }}</td>


                            <td class="td-actions text-right">
                                {{--OK +- --}}
                                <a href="javascript:void(0);" class="modalCategoria" data-toggle="modal" data-target="#modal-categoria" id-categoria="{{ $cats['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href={{route('cadastroCampo')}} class="addItem" id-categoria="{{ $cats['id'] }} "><i class="material-icons blue-icon">star</i></a>

                            </td>
                        </tr>

                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--</div>--}}
    {{--</div>--}}
@endsection

@section('partials')
    @include('partials.modalCategoria')
@endsection



