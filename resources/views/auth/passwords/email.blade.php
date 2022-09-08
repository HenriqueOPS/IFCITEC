@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 60px; ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <br>
                <h3 class="text-center" style="width: 90%; margin: auto; border-bottom: 1px solid #ccc;">Redefinir Senha</h3>
                <br>
                <div class="content text-center box-logo">
                    <a class="btn btn-simple btn-just-icon">
                        <img src="{{ asset('img/logonormal.png') }}" title="IFCITEC" height="110" />
                    </a>
                </div>
                <div class="panel-body">
                @if (isset($success))
                <div class="alert alert-success">
                    {{ $success }}
                </div>
                @endif

                @if (isset($error))
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>
                        {{ $error }}
                </div>
                @endif

                <form method="POST" action="{{ route('recuperar.senha') }}">
					{{ csrf_field() }}

                    <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                            <div class="col-xs-11">
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
                            </div>
                            <div class="col-md-offset-3 col-xs-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons">send </i> Enviar link de redefinição
                                </button>
                            </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
