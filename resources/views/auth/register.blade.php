@extends('layouts.app')


@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
<link href="{{ asset('css/datepicker/bootstrap-datepicker.standdalone.css') }}" rel="stylesheet">
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
<style>
  .news {
    margin-top: 4.5%;
  }
</style>
@endsection

@section('content')
<div class="container" style="margin-top: 30px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Participante</h2>
                    </div>

                </div>
                <form name="f1" method="POST" action="{{ route('register') }}">

                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                    <div class="row">
                    <div class="col-md-12">
                        <div style="background-color:{{ $coravisos }}">
                            <div class="container-fluid">
                            <br>
                            <div>
                                <i class="material-icons" style="color: white;">info_outline</i>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="fechar-alerta">
                                <span aria-hidden="true"><i class="material-icons">clear</i></span>
                            </button>
                            </div>
                          
                            <div class="text-center">
                                {!! $aviso1 !!}
                            </div>
                            </div>
                        </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                        $(document).ready(function() {
                            $('#fechar-alerta').click(function() {
                            $(this).closest('.col-md-12').hide();
                            });
                        });
                        </script>
                        <div class="col-md-12 text-center">
                            <div class="social-line" style="margin-top: 25px">
                                <a>
                                    <img src="{{ asset('img/logo.png') }}" title="IFCITEC" height="75" />
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">

                            <div class="input-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                            <div class="form-group label-floating">
                                <label class="control-label">Nome</label>
                                <input type="text" class="form-control" name="nome" value="{{ old('nome') }}" required oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" required> 
                                 </div>

                            <div class="form-group label-floating">
                                <label class="control-label">Sobrenome</label>
                                <input type="text" class="form-control" name="sobrenome" value="{{ old('sobrenome') }}" required oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" required>
                            </div>

        <input type="hidden" name="nome_completo" id="nome_completo" value="{{ old('nome') }} {{ old('sobrenome') }}">
                               @if ($errors->has('nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group {{ $errors->has('genero') ? ' has-error' : '' }}">
                           
                            <span class="input-group-addon ">
                                    <i class="material-icons">wc</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Gênero</label>
                                </div>
                                <input type="radio" id="masculino" name="genero" value="M" required>
                                <label style="margin-top:5px; margin-right:15px;">Masculino</label>
                                 <input type="radio" id="feminino" name="genero" value="F">
                                 <label style="margin-left:0px;">Feminino</label>
                                 @if($errors->has('genero'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('genero') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="input-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">call_to_action</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">CPF</label>
                                    <input type="text" OnKeyPress="formatar('###.###.###-##', this)" maxlength="14" class="form-control" pattern="^([0-9][0-9][0-9].)+([0-9][0-9])" name="cpf" value="{{old('cpf')}}" required>
                                </div>
                                @if ($errors->has('cpf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cpf') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Data Nascimento</label>
                                    <input type="text" class="form-control datepicker" name="dt_nascimento" value="{{ old('dt_nascimento') }}"  required>
                                </div>
                                @if ($errors->has('dt_nascimento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">done</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Confirme o Email</label>
                                    <input type="email" class="form-control" name="email_confirmation" required>
                                </div>
                            </div>

                            <div class="input-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">perm_phone_msg</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Whatssap</label>
                                    <input type="tel" OnKeyPress="formatar('## #####-####', this)" class="form-control" name="telefone" maxlength="13" value="{{ old('telefone') }}" required>
                                </div>
                                @if ($errors->has('telefone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('telefone') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('camisa') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <img class="gray-icon" src="{{ asset('img/tshirt-crew.svg') }}"  />
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Camisa</label>
                                    <select id="camisa-select" name="camisa" value="{{ old('camisa') }}" required>
                                      <option value="P">P</option>
                                      <option value="M">M</option>
                                      <option value="G">G</option>
                                      <option value="GG">GG</option>
                                      <option value="X1">X1</option>
                                    </select>
                                    @if ($errors->has('camisa'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('camisa') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="input-group{{ $errors->has('senha') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Senha</label>
                                    <input type="password" class="form-control" name="senha" required>
                                </div>
                                @if ($errors->has('senha'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('senha') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('senha') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">done</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Confirme a Senha</label>
                                    <input type="password" class="form-control" name="senha_confirmation" required>
                                </div>
                            </div>

                            <div class="input-group{{ $errors->has('senha') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">assignment</i>
                                </span>
                                <div class="checkbox news">
                                    <label>
                                      <span style="margin-right: 5pt;">
                                        Deseja receber informações sobre as novas edições da IFCITEC?
                                      </span>
                                      <input type="checkbox" name="newsletter" value=true checked>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Inscrever</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
    var oldCamisa = $('#camisa-select').attr("value");
    $('#camisa-select').selectize({
        placeholder: 'Selecione o tamanho...',
        onInitialize: function () {
            this.setValue(oldCamisa, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });
});

$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR',
    templates: {
        leftArrow: '&lsaquo;',
        rightArrow: '&rsaquo;'
    },
});

function formatar(mascara, documento) {

    var i = documento.value.length;
    var saida = mascara.substring(0, 1);
    var texto = mascara.substring(i)

    if (texto.substring(0, 1) != saida) {
        documento.value += texto.substring(0, 1);
    }
}

</script>
@endsection
