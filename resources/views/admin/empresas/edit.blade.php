@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Editar Empresa</h2>
                        </div>
                    </div>
                    <form method="post" action="{{ route('editaEmpresa') }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="id_empresa" value="{{ $dados->id }}">
                        <input type="hidden" name="id_endereco" value="{{ isset($data->id) ? $data->id : '0' }}">


                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">account_balance</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome Completo</label>
                                        <input type="text" class="form-control" name="nome_completo"
                                            value="{{ isset($dados->nome_completo) ? $dados->nome_completo : '' }}"
                                            required>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">account_balance</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome Curto</label>
                                        <input type="text" class="form-control" name="nome_curto"
                                            value="{{ isset($dados->nome_curto) ? $dados->nome_curto : '' }}" required>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">mail</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">E-mail da Escola</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ isset($dados->email) ? $dados->email : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">local_phone</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Telefone da Escola</label>
                                        <input type="text" class="form-control" name="telefone"
                                            value="{{ isset($dados->telefone) ? $dados->telefone : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">my_location</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">CEP</label>
                                        <input type="text" class="form-control" name="cep" id="cep"
                                            value="{{ isset($data->cep) ? $data->cep : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">place</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Rua</label>
                                        <input type="text" class="form-control" name="endereco" id="rua"
                                            value="{{ isset($data->endereco) ? $data->endereco : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">near_me</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Bairro</label>
                                        <input type="text" class="form-control" name="bairro" id="bairro"
                                            value="{{ isset($data->bairro) ? $data->bairro : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">near_me</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Cidade</label>
                                        <input type="text" class="form-control" name="municipio" id="cidade"
                                            value="{{ isset($data->municipio) ? $data->municipio : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">near_me</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Estado</label>
                                        <input type="text" class="form-control" name="uf" id="uf"
                                            value="{{ isset($data->uf) ? $data->uf : '' }}" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">exposure_zero</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Número</label>
                                        <input type="text" class="form-control" name="numero"
                                            value="{{ isset($data->numero) ? $data->numero : '' }}" required>
                                    </div>
                                </div>
                                
                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Salvar Alterações</button>
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
