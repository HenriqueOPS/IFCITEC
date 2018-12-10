@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">

<style>
    .container-login{margin-top: 100px;}
    .box-logo{padding: 0 !important;}
    .footer .link{
        display: block;
        line-height: 25px;
        margin-bottom: 3px;
    }
    .footer{margin-bottom: 25px;}
</style>

@endsection

@section('content')
<div class="container container-login">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">

            <div class="card card-signup">

                <div class="content text-center box-logo">
                    <a class="btn btn-simple btn-just-icon">
                        <img src="{{ asset('img/logonormal.png') }}" title="IFCITEC" height="90" />
                    </a>
                </div>

                <form class="form" method="post" action="{{ route('login') }}">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <div class="content">

                        {{ csrf_field() }}
                        
                        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <input type="text" class="form-control" placeholder="Email..." name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <input type="password" placeholder="Senha..." class="form-control" id="password" name="password" required>

                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                    </div>

                    <div class="footer text-center">
                        <input type="submit" class="btn btn-primary" value="Entrar">
                        <a class="link" href="{{ url('/cadastro') }}" >REGISTRE-SE</a>
                        <a class="link" href="{{ route('password.request') }}">ESQUECEU SUA SENHA?</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


