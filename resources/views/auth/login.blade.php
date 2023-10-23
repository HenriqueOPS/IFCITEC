<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'IFCITEC') }}</title>
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="icon" href="{{ asset('img/icons/32x32.png') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('img/icons/192x192.png') }}" sizes="192x192">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('img/icons/180x180.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <style>
        /* Your existing styles here */
    </style>
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
            margin-bottom: 10px;
        }

        .masthead {
            background-size: cover;
            background-position: center;
            background-attachment: fixed;   
            height: 100vh;
        }

        .btn {
            background-image: linear-gradient(to right, #006175 0%, #00a950 100%);
            border-radius: 20px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 43px;
            font-size: 1.6em;
            position: relative;
            text-decoration: none;
            text-transform: none;
            margin: 1rem 5rem;
        }

        .btn:hover {
            color: #fff;                
        }
        #image {
            margin-top: -45px
        }
    </style>
    
    <div class="container-login container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">
                <div class="card card-signup" style="border-radius:50px;">
                    <div  id="image" class="content box-logo text-center">
                        <img src="data:image/png;base64,{{ $logologin }}" title="IFCITEC" height="90" />
                    </div>

                    <div class="content">
                        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <input id="email" type="text" class="form-control" placeholder="Email..." name="email" value="{{ old('email') }}" required>
                            <span class="help-block">
                                <strong id="emailError" style="color:red;"></strong>
                            </span>
                        </div>

                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <span class="input-group-addon">
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <input id="password" type="password" placeholder="Senha..." class="form-control" id="password" name="password" required>
                            <span class="help-block">
                                <strong id="passwordError" style="color:red;"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="footer text-center" style=" display:flex;flex-direction: column;align-items: center;">
                        <div id="loginForm">
                            <button class="btn btn-primary btn-sm" onclick="submitLoginForm()">
                                <span class="material-symbols-outlined" style="margin: 0px 10px 0px 0px">home</span>
                                ENTRAR
                            </button>
                        </div>
                        <a class="btn btn-primary btn-sm" href="{{ url('/cadastro') }}">
                            <span class="material-symbols-outlined" style="margin: 0px 10px 0px 0px">person</span>
                            INSCREVER
                        </a>
                        <a class="btn btn-primary btn-sm" href="{{ route('password.request') }}">
                            <span class="material-symbols-outlined" style="margin: 0px 10px 0px 0px">lock_reset</span>
                            MUDAR SENHA
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/material.min.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>
    <script>
    function submitLoginForm() {
        var email = $("#email").val(); // Get the value of the email field
        var password = $("#password").val(); // Get the value of the password field

        var formData = {
            email: email,
            password: password
        };

        $.ajax({
            type: "POST",
            url: "{{ route('login.verification') }}",
            data: formData,
            success: function(response) {
                console.log(response);
                window.location.href = "{{ route('ifcitec.home') }}";
            },
            error: function(xhr, status, error) {
                var errors = xhr.responseJSON;
                console.log(errors);
                console.log(errors.password[0])
                if(errors.password){
                    $("#passwordError").text(errors.password[0]);
                }
                if(errors.email){
                    $("#emailError").text(errors.email[0]);
                }
            }
        });
    }
</script>

    <style>
        .btn {
            background-color: {{$corbotoes}} !important; 
        }
    </style>
</body>
</html>
