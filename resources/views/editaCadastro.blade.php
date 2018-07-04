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
                        <h2>Editar Cadastro</h2>
                    </div>

                </div>
                <form name="f1" method="post" action="{{ route('editaCadastro') }}">

                    {{ csrf_field() }}

                    <div class="row">

                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="col-md-12 text-center">
                                <h3>Meus Dados</h3>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <img class="gray-icon" src="{{ asset('img/account-card-details.svg') }}"  />
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">RG</label>
                                    <input type="text" class="form-control" name="rg" value="{{isset($dados->rg) ? $dados->rg : ''}}" required>
                                </div>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>

                            <div class="input-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome</label>
                                    <input type="text" class="form-control" name="nome" value="{{isset($dados->nome) ? $dados->nome : ''}}" required>
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
                                    <input type="text" OnKeyPress="formatar('###.###.###-##', this)" maxlength="14" class="form-control" name="cpf" value="{{isset($dados->cpf) ? $dados->cpf : ''}}" required>
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
                                    <input type="text" class="form-control datepicker" name="dt_nascimento" value="{{isset($dados->dt_nascimento) ? $dados->dt_nascimento : ''}}"  required>
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
                                    <input type="text" class="form-control" name="email" value="{{isset($dados->email) ? $dados->email : ''}}" required>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">phone</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Telefone</label>
                                    <input type="text" class="form-control" name="telefone" maxlength="15" value="{{isset($dados->telefone) ? $dados->telefone : ''}}">
                                </div>
                                @if ($errors->has('telefone'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('telefone') }}</strong>
                                </span>
                                @endif
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

