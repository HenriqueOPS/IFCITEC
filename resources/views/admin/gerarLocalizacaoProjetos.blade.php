@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Gerar Localização de Projetos</h2>
                    </div>
                </div>
                <form method="post" action="{{ route('geraLocalizacaoProjetos', $edicao)}}">

                    {{ csrf_field() }}


                    <div class="row" id="selects">
                        <div id="displayOriginal">
                           <div>
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Bloco</label>
                                    <input type="text" class="form-control" name="bloco[]" required>
                                </div>
                            </div>

        
                            <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                  <input name="de[]" type="number" class="form-control" placeholder="De... (Sala)">
                                </div>
                                <div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                  <input name="ate[]" type="number" class="form-control" placeholder="Até... (Sala)">
                                </div>
                            </div>


                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero de Projetos Por Sala</label>
                                    <input type="text" class="form-control" name="num[]" required>
                                </div>
                            </div>

                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="form-group">
                                    <label class="control-label">Selecione um Nível</label>
                                    <select id="nivel-select" name="nivel[]" required>
                                        <option></option>
                                        @foreach ($niveis as $nivel)
                                            <option value="{{$nivel->id}}">{{$nivel->nivel}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-md-offset-1" class="col-xs-6">
                                <a onclick="addBloco()" class="btn btn-success btn-fab btn-fab-mini btn-round" role="button">
                                    <i class="material-icons">add</i>
                                </a>
                            </div>
                           </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button name="button" value="1" class="btn btn-primary">Gerar Identificação</button>
                                <button name="button" value="2" class="btn btn-primary">Gerar Localização</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="text/javascript">
var total = 0;

    function deletaBloco(id) {
        console.log($('#' + id));
        $('#' + id).remove();
    }

    function addBloco() {
        var newSelect = $("#displayOriginal");
        newSelect = newSelect.clone();
        id =  'select-' + total++;
        newSelect.find('div').attr("id", id);
        newSelect.find('div').css('display', 'block');

        button = '<a class="btn btn-danger btn-fab btn-fab-mini btn-round" role="button" onclick="deletaBloco(\'' + id + '\')" style="color: red;"><i class="material-icons">remove</i></a>'; 

        console.log(button);
        newSelect.find('a').append(button);

        $("#selects").append(newSelect.html());

        

        console.log(newSelect.find('div select'));
}
$(document).ready(function () {
var oldNivel = $('#nivel-select').attr("value", id);

    $nivelSelect = $('#nivel-select').selectize({
        placeholder: 'Selecione um Nível...',
        preload: true,
        onInitialize: function () {
            this.setValue(oldNivel, true);
            $('.selectize-input').addClass('form-control');
        },
    });
});
</script>
@endsection