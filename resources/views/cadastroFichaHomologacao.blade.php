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
                        <h2>Cadastro de Fichas</h2>
                    </div>
                </div>
                <form name="f1" method="GET" action="">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome da Ficha</label>
                                    <input type="text" class="form-control" name="tipo_ficha" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">event_note</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Edição</label>
                                    <select class="form-control" id="edicao_id">
                                         @foreach($edicoes as $edicao)
                                        <option>{{$edicao->ano}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr><br>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome da Sessão</label>
                                    <input type="text" class="form-control" name="tipo_ficha" required>
                                </div>
                            </div>
                        </div>

                        <div id="clone-form">
                        <div class="campos">
                            <div class="col-md-10 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">text_fields</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome do Item</label>
                                        <input type="text" class="form-control" name="campo" required>
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
                            <div class="col-md-offset-1">
                            <button href="javascript:void(0);" class="clonador btn btn-primary btn-fab btn-fab-mini btn-round">
                                <i class="material-icons">add</i>
                            </button>
                            <button class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="removerCampos(this);return false;">
                                <i class="material-icons">remove</i>
                            </button>
                        </div>
                        </div>
                    </div>


                    <hr>
                    </div>
                    <button href="javascript:void(0);" class="clonador btn btn-primary btn-fab btn-fab-mini btn-round">
                                <i class="material-icons">add</i>
                            </button>
                            <button class="btn btn-primary btn-fab btn-fab-mini btn-round" onclick="removerCampos(this);return false;">
                                <i class="material-icons">remove</i>
                            </button>
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
$('.clonador').click(function(){
$('.campos').clone().appendTo($('#clone-form'));
});


</script>
@endsection
