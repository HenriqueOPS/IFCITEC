@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Fichas de Homologação dos resumos</h2>
                    </div>
                </div>
                <form name="f1" method="GET" action="">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">event_note</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Edição</label>
                                    @foreach()
                                    <select class="form-control" id="">
                                        <option>Edição 2015</option>
                                    </select>
                                    @endforeach
                                </div>
                            </div>
                            <hr><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Resumo</h3>
                        </div>


                        <div id="origem">
                            <div class="col-md-10 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">text_fields</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome do Item</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="optionsCheckboxes" checked>
                                        Não apresenta
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="optionsCheckboxes" checked>
                                        Insuficiente
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="optionsCheckboxes" checked>
                                        Regular
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="optionsCheckboxes" checked>
                                        Bom
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-offset-2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="optionsCheckboxes" checked>
                                        Ótimo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="destino">
                        </div>
                        <div class="col-md-offset-1">
                            <button  class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="duplicarCampos();">
                                <i class="material-icons">add</i>
                            </button>
                            <button  class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="removerCampos();">
                                <i class="material-icons">remove</i>
                            </button>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary" id="add_field" value="adicionar">Cadastrar</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')
<script>
    function duplicarCampos() {
        var clone = document.getElementById('origem').cloneNode(true);
        destino.appendChild(clone);
        var camposClonados = clone.getElementsByTagName('div');
        for (i = 0; i < camposClonados.length; i++) {
            camposClonados[i].value = '';
        }
    }
    function removerCampos(id) {
        var node1 = document.getElementById('destino');
        node1.removeChild(node1.childNodes[0]);
    }
</script>
@endsection