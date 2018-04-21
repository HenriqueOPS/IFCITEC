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
                    <div class="col-md-10 col-md-offset-1">
                        <h2>Cadastro de Comissão Avaliadora</h2>
                    </div>
                </div>
                <form method="POST">

                     {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center">
                                <div class="container-fluid">
                                    <div class="alert-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                    </button>
                                    <b>ATENÇÃO: </b>É de total resposabilidade do usuário a veracidade dos dados aqui informados
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1">

                            {{ csrf_field() }}
                            <input type="hidden" name="inscricao" value="avaliacao">

                            <div class="input-group{{ $errors->has('titulacao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">bookmark</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Titulacao</label>
                                    <input type="text" class="form-control" name="titulacao" value="{{old('titulacao')}}" >
                                </div>
                                @if ($errors->has('titulacao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('titulacao') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('lattes') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">insert_link</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Link Lattes</label>
                                    <input type="url" class="form-control" name="lattes" value="{{old('lattes')}}" required>
                                </div>
                                @if ($errors->has('lattes'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lattes') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('profissao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">assignment_ind</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Profissao</label>
                                    <input type="text" class="form-control" name="profissao" value="{{old('profissao')}}" required>
                                </div>
                                @if ($errors->has('profissao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('profissao') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('instituicao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Instituicao</label>
                                    <input type="text" class="form-control" name="instituicao" value="{{old('instituicao')}}" required>
                                </div>
                                @if ($errors->has('instituicao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('instituicao') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h2>Endereço</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">

                          <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">my_location</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">CEP</label>
                                    <input type="text" class="form-control" name="cep" id="cep" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Rua</label>
                                    <input type="text" class="form-control" name="endereco" id="rua" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">near_me</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Bairro</label>
                                    <input type="text" class="form-control" name="bairro" id="bairro" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">near_me</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Cidade</label>
                                    <input type="text" class="form-control" name="municipio" id="cidade" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">near_me</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Estado</label>
                                    <input type="text" class="form-control" name="uf" id="uf" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">exposure_zero</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Número</label>
                                    <input type="text" class="form-control" name="numero" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>Você pode escolher varios:</p>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="3">
                                    <span style="color: black">Quero ser Avaliador</span>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="4">
                                    <span style="color: black">Quero ser Homologador</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button href="javascript:void(0);" class="confirma btn btn-primary">Inscrever</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal">
    <div class="modal-dialog" role="document1">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inscrição Comissão Avaliadora</h5>
            </div>

            <div class="modal-body">
                <span>Para confirmar sua inscrição como revisor/avaliador, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="password" name="password" required>              
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="confirmado btn btn-primary" data-dismiss="modal">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        templates: {
            leftArrow: '&lsaquo;',
            rightArrow: '&rsaquo;'
        },
    });
    $(document).ready(function () {
        var oldArea = $('#area-select').attr("value");

        $nivelSelect = $('#area-select').selectize({
            placeholder: 'Escolha a Área...',
            preload: true,
            onInitialize: function () {
                this.setValue(oldArea, false);
                $('.selectize-input').addClass('form-control');
            },
        });
    });
</script>
<script type="text/javascript" >

    $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#rua").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
        }
        
        //Quando o campo cep perde o foco.
        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#rua").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#rua").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                            $("#ibge").val(dados.ibge);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });

</script>
<script type="application/javascript">
$('.confirma').click(function(){

    $("#modal").modal();

    $('.confirmado').click(function(){
        var urlConsulta = './comissao/cadastrar/'+$('#password').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                alert("Sua inscrição foi enviada com sucesso");
                location.href = './autor';
            }else{
                alert("Senha incorreta");
            }

        });
    });

});
</script>
@endsection