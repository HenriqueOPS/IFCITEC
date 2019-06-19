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
                    <li>
                        <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                            <i class="material-icons">description</i>
                            Montar Ficha
                        </a>
                    </li>
                </ul>
{{--BOTAO--}}
                {{--<div>--}}
                    {{--<div class="col-md-3">--}}
                      {{--<button   onclick="escondeForm()" class="btn btn-primary btn-round">--}}
                            {{--<i class="material-icons">add</i> Adicionar Categoria--}}
                      {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div id="bot" >
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Cadastro de Categorias</h2>
                        </div>
                    </div>
                    <form name="criarCategoria" method="POST" action="{{ route('cadastradaCategoria')}}">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">event_note</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Edição</label>
                                        <select name="edicao_id" value="{{old('edicao_id')}}" class="tp-select">
                                            @foreach($edicoes as $edicao)
                                                <option value="{{$edicao->id}}">{{\App\Edicao::numeroEdicao($edicao->id)}}
                                                    IFCITEC
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nível</label>
                                        <select name="nivel_id" value="{{old('nivel_id')}}"
                                                class="tp-select">
                                            @foreach($nomeN as $nivel)
                                                <option value="{{$nivel->id}}">{{$nivel->nivel}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div id="categoria">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">text_fields</i>
                    </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nome da Categoria</label>
                                            <input type="text" class="form-control" name="descricao"
                                                   required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">text_fields</i>
                    </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Peso da Categoria</label>
                                            <input type="text" class="form-control" name="peso_categoria"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Cadastrar</button>
                            </div>

                        </div>


                    </form>
                </div>
                </div>
            </div>
        </div>
            </div>

@endsection


@section('js')

    <script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

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


            $tpSelect= $tpSelect[0].selectize;
        });
    </script>

    {{--<script>--}}
        {{--function escondeForm() {--}}
            {{--var x = document.getElementById('bot');--}}
            {{--if (x.style.visibility === 'hidden') {--}}
                {{--x.style.visibility = 'visible';--}}
            {{--} else {--}}
                {{--x.style.visibility = 'hidden';--}}
            {{--}--}}
        {{--}--}}
    {{--</script>--}}

@endsection
