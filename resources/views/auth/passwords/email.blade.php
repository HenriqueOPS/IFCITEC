@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

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
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                </div>
                @endif

                <form method="POST" action="{{ route('recuperar.senha') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
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
                            <div class="col-md-offset-3">
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
