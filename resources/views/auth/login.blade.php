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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body class="masthead" style="background-image: url(data:image/png;base64,{{ $teladelogin }});">
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
        height:100vh;
        }
        .btn {
        background-image: linear-gradient(to right, #006175 0%, #00a950 100%);
        border-radius: 20px;
        box-sizing: border-box;
        display: flex; /* Tornar os botões elementos flexíveis */
        justify-content: center; /* Centralizar horizontalmente o conteúdo */
        align-items: center; /* Centralizar verticalmente o conteúdo */
        height: 50px; /* Altura dos botões */
        font-size: 1.6em; /* Fonte dos botões */
        position: relative;
        text-decoration: none;
        text-transform: none;
        margin: 1.5rem 5rem;
        }
        .btn:hover {
        color: #fff;                
        }
    </style>


    <div class="container-login container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">

                <div class="card card-signup" style="border-radius:50px;">

                    <div class="content box-logo text-center">
                     
                            <img src="data:image/png;base64,{{ $logo }}" title="IFCITEC" height="90" />
                 
                    </div>

                    <form class="form" id="loginForm" method="post" action="{{ route('login.verification') }}">
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

                        <div class="footer text-center" style=" display:flex;flex-direction: row;align-items: center;">
                            <div id="#loginForm">
                                <button class="btn btn-primary btn-sm" style="margin: 20px 0px 0px 30px"><span class="material-symbols-outlined" style="margin: 0px 10px 0px 0px">home</span>ENTRAR</button>
                            </div>    
                        <a class="btn btn-primary btn-sm" href="{{ url('/cadastro') }}" style="margin: 20px 0px 0px 50px"><span class="material-symbols-outlined" style="margin: 0px 10px 0px 0px">person</span>INSCREVER</a>
                        </div>
                        <div class="footer text-center" style=" display: flex;flex-direction: column;align-items: center;">
                            <a class="btn btn-primary btn-sm" href="{{ route('password.request') }}"><span class="material-symbols-outlined" style="margin: 0px 10px 0px 0px">lock_reset</span>MUDAR SENHA</a>
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

    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(event) {
                event.preventDefault(); // Impede o comportamento padrão do envio do formulário

                // Obtenha os dados do formulário
                var formData = $(this).serialize();

                // Envie os dados para o servidor usando Ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('login.verification') }}",
                    data: formData,
                    success: function(response) {
                        // Processar a resposta do servidor aqui, se necessário
                        console.log(response);
                        // Se o login for bem-sucedido, redirecionar para a página inicial
                        window.location.href = "{{ route('home') }}";
                    },
                    error: function(xhr, status, error) {
                        // Lidar com erros, se houver, aqui
                        console.log(error);
                    }
                });
            });
        });
    </script>
    </body>
    <style>
           .btn {
                background-color: {{$corbotoes}} !important; 
            }
    </style>
</html>