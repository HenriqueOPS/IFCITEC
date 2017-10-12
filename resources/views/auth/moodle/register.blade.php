@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h2>Cadastro de Participante</h2>
                    </div>
                </div>
                <form method="POST" action="{{route('register')}}">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">

                            {{ csrf_field() }}
                            <div class="input-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome Completo</label>
                                    <input type="text" class="form-control" name="nome" value="{{ $nome }}" disabled>
                                </div>
                                @if ($errors->has('nome'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ $email }}" disabled>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
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

</script>
@endsection
