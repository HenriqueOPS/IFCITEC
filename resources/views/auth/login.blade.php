<!DOCTYPE html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IFCITEC') }}</title>

    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Fonts and icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />

    <!-- Icons -->
    <link rel="icon" href="{{ asset('img/icons/32x32.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('img/icons/192x192.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon-precomposed" href="{{ asset('img/icons/180x180.png') }}" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body class="masthead" style="background-image: url({{ asset('img/teladelogin.png') }});">
    <style>
        .card-signup {
            margin-top:100px;   
        }

        .box-logo {
            padding: 0 !important;
        }

        .footer .link {
            display: block;
            line-height: 25px;
            margin-bottom: 3px;
        }

        .footer {
            margin-bottom: 25px;
        }
        .masthead{
        background-size:cover;
        background-position:center;
        background-attachment: fixed;   
        backdrop-filter: blur(10px);
        height:100vh;
    }
    </style>


    <div class="container-login container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">

                <div class="card card-signup" style="border-radius:50px;">

                    <div class="content box-logo text-center">
                        <a class="btn btn-simple btn-just-icon">
                            <img src="{{ asset('img/logonormal.png') }}" title="IFCITEC" height="90" />
                        </a>
                    </div>

                    <form class="form" method="post" action="{{ route('login.verification') }}">
                        {{ csrf_field() }}

                        <div class="content">
                            <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <input type="text" class="form-control" placeholder="Email..." name="email"
                                    value="{{ old('email') }}" required>
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
                                <input type="password" placeholder="Senha..." class="form-control" id="password"
                                    name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="footer text-center">
                            <input type="submit" class="btn btn-primary" value="Entrar">
                            <a class="link" href="{{ url('/cadastro') }}">REGISTRE-SE</a>
                            <a class="link" href="{{ route('password.request') }}">ESQUECEU SUA SENHA?</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>

    <!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>
    </body>

</html>