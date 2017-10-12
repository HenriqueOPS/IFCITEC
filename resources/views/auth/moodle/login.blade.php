@extends('layouts.app')

@section('css')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
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
                        <a href="{{route('login')}}" id="moodleAuth" class="btn btn-simple btn-just-icon">
                            <i class="material-icons medium-icon">email</i>
                        </a>
                    </div>
                </div>
                <p class="text-divider">Login via Moodle:</p>
                @if($errors->has('moodleError'))
                <div class="alert alert-danger">
                    <div class="container-fluid text-center">
                        <div class="alert-icon">
                            <i class="material-icons">error_outline</i>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="material-icons">clear</i></span>
                        </button>
                        <b>Erro: </b>{{ $errors->first('moodleError') }}
                    </div>
                </div>
                @endif
                <form class="form" method="POST" action="{{ route('moodleLoginPost') }}">
                    <div class="content">
                        {{ csrf_field() }}
                        <div class="input-group{{ $errors->has('escola') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">school</i>
                            </span>
                            <select id="escola-select" placeholder="Escola/Instituição..." name="escola" required>
                                <option></option>
                                @foreach ($escolas as $escola)
                                <option value="{{$escola->id}}">{{$escola->nome_curto}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('escola'))
                            <span class="help-block">
                                <strong>{{ $errors->first('escola') }}</strong>
                            </span>
                            @endif
                        </div>


                        <div class="input-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <input type="text" class="form-control" placeholder="Usuário..." name="username" value="{{ old('username') }}" required>
                            @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
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
                    </div>
                </form>
                <div class="footer text-center">
                    <button id="moodleInfo" class="btn btn-primary btn-simple btn-link">NÃO ENCONTROU SUA ESCOLA?</button>
                    <div class="info-animate fadeInDown">
                        Entre em contato via email, informando o nome de sua 
                        escola e o link do Moodle utilizado por ela. 
                        Você poderá fazer seu login normalmente por aqui: <br>
                        <a class="link" href="{{ url('/login') }}" >Login Clássico</a>
                    </div>
                    <button id="senhaInfo" class="btn btn-primary btn-simple btn-link"> ESQUECEU SUA SENHA?</button>
                    <div class="info-animate fadeInDown">
                        Sua senha deverá ser recuperada através do sistema de Moodle de sua instituição.
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

<script type="text/javascript">
$('.info-animate').hide();
    
$('#escola-select').selectize({
    placeholder: 'Escola/Instituição...',
    onInitialize: function () {
        $('.selectize-control').addClass('form-group');
        $('.selectize-input').addClass('form-control');
    },
});

$('#moodleInfo').click(function (e) {
    $('.info-animate').hide();
    $('#moodleInfo + .info-animate').show();
    $('#moodleInfo + .info-animate').addClass('animated');
});

$('#senhaInfo').click(function (e) {
    $('.info-animate').hide();
    $('#senhaInfo + .info-animate').show();
    $('#senhaInfo + .info-animate').addClass('animated');
});
</script>
@endsection