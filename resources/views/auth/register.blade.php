@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
<link href="{{ asset('css/datepicker/bootstrap-datepicker.standdalone.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Participante</h2>
                    </div>

                </div>
                <form name="f1" method="POST" action="{{route('register')}}">
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
                                    <b>ATENÇÃO: </b>É de total resposabilidade do usuário a veracidade dos dados informados, pois será utilizado para a emissão de certificados
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="social-line">
                                <a class="btn btn-simple btn-just-icon">
                                    <img src="{{ asset('img/logo.png') }}" title="IFCITEC" height=100px" />
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">

                            {{ csrf_field() }}
                            <div class="input-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome</label>
                                    <input type="text" class="form-control" name="nome" value="{{old('nome')}}" required>
                                </div>
                                @if ($errors->has('nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">call_to_action</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">CPF</label>
                                    <input type="text" OnKeyPress="formatar('###.###.###-##', this)" maxlength="14" class="form-control" name="cpf" value="{{old('cpf')}}" required>
                                </div>
                                @if ($errors->has('cpf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cpf') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="col-md-offset-2">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="optionsCheckboxes" checked>
                                    Estou ciente que a falta de CPF, não permitirá a emissão de certificado
                                </label>
                            </div>
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
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Senha</label>
                                    <input type="password" class="form-control" name="senha" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">done</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Confirme a Senha</label>
                                    <input type="password" class="form-control" name="senha_confirmation" required>
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
<script type="text/javascript" src="{{asset('js/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript">


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