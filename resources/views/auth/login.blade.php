@extends('layouts.app')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <br><br>
            <div class="card card-signup">
                <div class="header header-primary text-center" id="cardLoginHeader">
                    <h4>Faça login via:</h4>
                    <div class="social-line">
                        <a href="{{route('moodleLogin')}}" id="moodleAuth" class="btn btn-simple btn-just-icon">
                            <img src="{{ asset('img/moodleIcon.png') }}" alt="Moodle Login" title="Moodle" height=30px" />
                        </a>
                    </div>
                </div>
                <p class="text-divider">Ou simplesmente:</p>
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