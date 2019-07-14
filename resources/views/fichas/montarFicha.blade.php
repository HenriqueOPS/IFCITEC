@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
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
                    <li class="active">
                        <a href="{{route('telaEscolheTipo')}}">
                            <i class="material-icons">description</i>
                            Montar Formulário
                        </a>
                    </li>
                </ul>


                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Montagem de Formulários</h2>
                    </div>
                </div>
                {{--{{ url("/escolher/{categorias}"}}--}}
                <form method="post" action="{{route('selecionarCategorias')}}">
                    {{csrf_field()}}
                    {{--<div class="row">--}}
                    {{--<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">--}}
                    {{--<div class="input-group">--}}
                    {{--<span class="input-group-addon">--}}
                    {{--<i class="material-icons">event_note</i>--}}
                    {{--</span>--}}
                    {{--<div class="form-group label-floating">--}}
                    {{--<label class="control-label">Edição</label>--}}
                    {{--<select name="edicao_id" value="{{old('edicao_id')}}" class="tp-select">--}}
                    {{--@foreach($edicoes as $edicao)--}}
                    {{--<option value="{{$edicao->id}}">{{\App\Edicao::numeroEdicao($edicao->id)}}--}}
                    {{--IFCITEC--}}
                    {{--</option>--}}
                    {{--@endforeach--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                    <span class="input-group-addon">
                    <i class="material-icons">event_note</i>
                    </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo do Formulário</label>
                                    {{--<select class="tp-select" name="tp" value="{{old('tipo') ? old('tipo'): ''}}" required>--}}
                                        {{--<option></option>--}}
                                        {{--@foreach ($tps as $tp)--}}
                                            {{--@if ($tp == old('tipo'))--}}
                                                {{--<option selected="selected" value="{{$tp->tipo}}"></option>--}}
                                            {{--@else--}}
                                                {{--<option value="{{$tp->tipo}}"></option>--}}
                                            {{--@endif--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                    <select name="tp" value="{{old('tipo')}}" class="tp-select">
                                        @foreach($tps as $tp)
                                            <option value="{{$tp->tipo}}">{{$tp->tipo}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="row">--}}
                        {{--<div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">--}}
                            {{--<div class="input-group">--}}
                    {{--<span class="input-group-addon">--}}
                    {{--<i class="material-icons">event_note</i>--}}
                    {{--</span>--}}
                                {{--<div class="form-group label-floating">--}}
                                    {{--<label class="control-label">Tipo do Formulário</label>--}}
                                    {{--<select name="tp" value="{{old('categoria_avaliacao')}}" class="tp-select">--}}
                                        {{--@foreach($categorias as $categoria)--}}
                                            {{--<option value="{{$categoria->categoria_avaliacao}}">{{$categoria->categoria_avaliacao}}</option>--}}
                                        {{--@endforeach--}}
                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-md-6 col-md-offset-3 text-center">
                        <button class="btn btn-primary">Enviar</button>
                    </div>

                </form>


            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

    {{--SCRIPT PARA SELECIONAR--}}
    <script type="text/javascript">
        $(document).ready(function () {

            var $tpSelect, $tpSelect;

            var oldTipo = $('.tp-select').attr("value");

            $edicaoSelect = $('.tp-select').selectize({
                placeholder: 'Escolha uma opção...',
                preload: true,
                onInitialize: function () {
                    this.setValue(oldTipo, false);
                    $('.selectize-input').addClass('form-control');
                },
            });


            //  $tpSelect = $tpSelect[0].selectize;
        });
    </script>


@endsection
