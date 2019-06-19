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
                    <li >
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


                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Critérios de Avaliação</h2>
                    </div>
                </div>
                <form name="criarCampo" method="POST" action="{{route('cadastradoCampo')}}">
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
                                        <i class="material-icons">text_fields</i>
                                    </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo do Campo</label>
                                    <select  name="tipo" class="tp-select">
                                        <option>Homologação</option>
                                        <option>Avaliação</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Categoria</label>
                                    <select name="categoria_id" value="{{old('categoria_id')}}" class="tp-select">
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}">
                                                {{$categoria->descricao}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Cadastrar</button>
                        </div>

                </form>


            </div>
        </div>
    </div>
    </div>

@endsection


@section('js')

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
