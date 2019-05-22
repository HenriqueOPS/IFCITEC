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
                        <a href="{{ route('cadastroCategoria') }}">
                            <i class="material-icons">description</i>
                            Adicionar Categoria
                        </a>
                    </li>

                    <li class="active">
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


                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Cadastro de Itens</h2>
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
                                        <select  name="tipoCampo"class="tp-select">
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
                                                    {{$categoria->categoria_avaliacao}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Campos--}}

                        <div class="row">
                            <div id="campos">

                                <div class="col-md-10 col-xs-9 col-xs-offset-1">
                                    <div>
                                        <div class="row">
                                            <a class="remover removerCampos"
                                               href="#">
                                                <i class="material-icons">remove</i>
                                            </a>

                                            {{--Nome Campo--}}
                                            <div class="input-group">


                                                <span class="input-group-addon">

                                        <i class="material-icons">text_fields</i>

                                        </span>

                                                <div class="form-group label-floating">

                                                    <label class="control-label">Nome do Campo</label>
                                                    <input type="text" class="form-control" name="campo[]" required>
                                                </div>
                                            </div>
                                        </div>
                                        {{--Checkbox--}}
                                        {{--<div class="col-md-offset-2">--}}
                                            {{--<div class="checkbox">--}}
                                                {{--<label>--}}
                                                    {{--<input type="checkbox" name="val_0[]" value="true" checked>--}}
                                                    {{--Binário--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}


                                        <div class="col-md-offset-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="val_0[]" value="true" checked>
                                                    Não apresenta
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-offset-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="val_25[]" value="true" checked>
                                                    Insuficiente
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-offset-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="val_50[]" value="true" checked>
                                                    Regular
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-offset-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="val_75[]" value="true" checked>
                                                    Bom
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-offset-2">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="val_100[]" value="true" checked>
                                                    Ótimo
                                                </label>
                                            </div>
                                        </div>


                                    </div>


                                </div>

                            </div>

                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Cadastrar</button>
                            </div>

                        </div>

                        {{--CLONAR CAMPOS--}}
                        <div class="col-md-offset-1" id="cloneCampo">
                            <a href="javascript:void(0);"
                               class="clonador btn btn-primary btn-fab btn-fab-mini btn-round">
                                <i class="material-icons">add</i>
                            </a>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')

    <script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            //PARA ADICIONAR O CLONE
            var html = $('#campos').html();
            $(document).on('click', '.clonador', function (e) {
                e.preventDefault();
                $('#campos').append(html);

                // PARA REMOVER
                //Depois que adicionei preciso atribuir os eventos
                $('.removerCampos').on('click', function (e) {
                    //alert("doi")
                    e.preventDefault();
                    $(this).parent().parent().remove();
                });
            })

        });


    </script>


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


    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js"></script>--}}
    {{--<script id="Scategoria" type="x-tmpl-mustache">--}}

    {{--</script>--}}

    {{--<script>--}}
    {{--var template = $('#Scategoria').html();--}}
    {{--Mustache.parse(template);   // optional, speeds up future uses--}}
    {{--var rendered = Mustache.render(template);--}}

    {{--$('#categoriasForm').append(rendered);--}}

    {{--$('.clonador').click(function () {--}}
    {{--$('#categoriasForm').append(rendered);--}}
    {{--});--}}

    {{--</script>--}}
@endsection
