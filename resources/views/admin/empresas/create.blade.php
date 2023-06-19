@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Cadastro de Empresa</h2>
                        </div>
                    </div>
                    <form method="post" action="{{ route('admin.empresas.cadastrar') }}">

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">account_balance</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome Completo</label>
                                        <input type="text" class="form-control" name="nome_completo" required>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">account_balance</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome Fantasia</label>
                                        <input type="text" class="form-control" name="nome_fantasia" required>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">mail</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">E-mail da Escola</label>
                                        <input type="text" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">local_phone</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Telefone da Escola</label>
                                        <input type="text" class="form-control" name="telefone" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">my_location</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">CEP</label>
                                        <input type="text" class="form-control" name="cep" id="cep" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">place</i>
                                    </span>
                                    <div class="form-group label-floating">
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
                                    <div class="form-group label-floating">
                                        <label class="control-label">Cidade</label>
                                        <input type="text" class="form-control" name="municipio" id="cidade" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">near_me</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Estado</label>
                                        <input type="text" class="form-control" name="uf" id="uf" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">exposure_zero</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Número</label>
                                        <input type="text" class="form-control" name="numero" required>
                                    </div>
                                </div>
                              
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .school-type-label {
            margin-top: 3%;
            margin-right: 2%;
        }
    </style>
@endsection


@section('js')
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.school-type').on('change', function() {
                $('input.school-type').not(this).prop('checked', false);
            });

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
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

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
@endsection
