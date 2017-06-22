@extends('layouts.app')

@section('content')
<body style="background-image: url(https://scontent.fpoa1-1.fna.fbcdn.net/v/t35.0-12/19250192_943481775794342_1136829307_o.png?oh=7b0380547fb3f88dd318ac6e4055213e&oe=5947BF13); background-position: absolute; background-size: cover">
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div class="card card-signup">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            <div class="header text-center" style="background-color: #3c4860">
                                <h4>Entre</h4>
                                <div class="social-line">
                                    <a href="https://moodle.canoas.ifrs.edu.br/" class="btn btn-simple btn-just-icon">
                                        <img src="http://www.wyversolutions.co.uk/post-images/2015/10/moodle-logo-thumb.png" title="Moodle" height="40" width="40" />
                                    </a>
                                </div>
                            </div>
                            <div class="content">
                                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">email</i>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Email..." name="email" value="{{ old('email') }}">
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
                                    <input type="password" placeholder="Password..." class="form-control" id="password" name="password" required>
                                    
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="footer text-center">
                                <br><button class="btn">Entrar</button><br><br><br>
                                <a href="x" class="link" style="color: #3c4860;">REGISTRE-SE</a><br>
                                <a class="link" style="color: #3c4860;" href="{{ route('password.request') }}"> ESQUECEU SUA SENHA?
                                </a><br><br><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </body>
@endsection
