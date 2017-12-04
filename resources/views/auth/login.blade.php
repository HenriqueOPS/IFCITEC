@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">
            <br><br><br><br><br>
            <div class="card card-signup">
                <div class="header header-primary text-center" id="cardLoginHeader">
                    <h4>Faça seu login:</h4>
                    <div class="social-line">
                        <a class="btn btn-simple btn-just-icon">
                            <img src="{{ asset('img/logonormal.png') }}" title="IFCITEC" height="100" />
                        </a>
                    </div>
                </div>
                <form class="form" method="POST" action="{{ route('login') }}">
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
                        <input type="submit" class="btn btn-primary" value="Entrar"><br>
                        <a class="link" href="{{ url('/register') }}" >REGISTRE-SE</a><br>
                        <a class="link" href="{{ route('password.request') }}"> ESQUECEU SUA SENHA?
                        </a><br><br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


