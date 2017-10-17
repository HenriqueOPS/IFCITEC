<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IFCITEC</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

        <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;

                background-image: url("{{asset('img/fundo.png')}}");
                background-size: 100%;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: 0 0;
                background-attachment: fixed;            

            }


            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('img/IFCITEC-logo.png')}}" class="img-responsive" width="50%">
                    </div>
                </div>


                <div class="links">
                    <br>
                    <a href="{{ url('/register') }}" class="btn btn-primary btn-round">Inscrever-se</a>
                    <br>
                    <br>
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-simple">Login</a>
                    <br>
                    <br>
                    <a href="http://ifcitec.canoas.ifrs.edu.br" class="btn btn-primary btn-simple">Mais Informações</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
