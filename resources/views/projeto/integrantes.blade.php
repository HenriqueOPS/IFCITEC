@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h2>Projeto</h2>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Autores</h3>
                        </div>
                </div>
                <div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email do Autor 1... (Obrigatório)</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="modal btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email do Autor 2... (Opcional)</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="modal btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error2">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email do Autor 3...(Opcional)</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="modal btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Orientador</h3>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email do Orientador... (Obrigatório)</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="modal btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h3>Coorientadores</h3>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email do Coorientador 1... (Opcional)</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="modal btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <span id="">Informe o email do novo integrante:</span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email do Coorientador 2... (Opcional)</label>
                                    <input type="text" id="email" class="form-control">
                                </div>
                            </div> 
                        </div>
                        <button id="pesquisa-pessoa" class="modal btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">search</i>
                        </button> 
                    </div>
                    <div class="col-md-12" id="error">
                        <br>
                        <div class="alert alert-danger">
                            <div class="container-fluid text-center">
                                <div class="alert-icon">
                                    <i class="material-icons">error_outline</i>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                </button>
                                <b>Erro: </b><span id="error-message"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="" class="btn btn-primary">Submeter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div  id="modal" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="nome-curtoModal"></h5>
        </div>
        <div class="modal-body">
                <div id="dados-pessoa">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <hr>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">face</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome</label>
                                        <input type="text" id="nome" name="nome" class="form-control" disabled>
                                    </div>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>


                                <div class="input-group{{ $errors->has('escola') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">school</i>
                                    </span>
                                    <div class="form-group">
                                        <label class="control-label">Escola</label>
                                        <select id="escola-select" name="escola" required>
                                            <option></option>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <input type="hidden" name="pessoa">
                                <input type="hidden" name="projeto" value="">
                            </div>
                        </div>
                </div>
    <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>
</div>
<!-- Fim Modal -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function () {
    $('#dados-pessoa').hide();
    $('#error').hide();
    $('#pesquisa-pessoa').click(function () {
        $('#dados-pessoa').hide();
        $('#error').hide();
        //
        var email = $('#email').val();
        var projeto = $("input[name='projeto']").val();
        $.get("projeto/" + projeto + "/vincula-integrante/" + email, function (data) {
            if (typeof data.error !== 'undefined') {
                $('#error-message').html(data.error);
                $('#error').show();
            } else {
                $('#nome').val(data.nome);
                $('#nome').trigger("change");
                $("input[name='pessoa']").val(data.id);
                $('#dados-pessoa').show();
            }
        });
    });



    $('#escola-select').selectize({
        placeholder: 'Digite a Escola...',
        onInitialize: function () {
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });
});
</script>

<script type="application/javascript">
$('.modal').click(function(){

    //recupera o e-mail do integrante
    //var email = $(this).attr('email-integrante');

    //monta a url de consulta
    //var urlConsulta = './//'+email;
    //faz a consulta via Ajax
    //$.get(urlConsulta, function (res){

        //console.log(res);

        //altera o DOM
        //$("#areaModal").html(res.dados.area_conhecimento);
        //$("#nivelModal").html(res.data.nivel);
        //$("#descricaoModal").html(res.dados.descricao);

        //abre a modal
        $("#modal").modal();

   // });

});
</script>
@endsection
