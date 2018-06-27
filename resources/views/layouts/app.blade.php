<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts and icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
        <link  href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
        <link  href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        <div id="app">
            @if (Auth::guest())
            @else
            <nav class="navbar navbar-default navbar-static-top"-->
                <div class="container">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ asset('img/logo.png') }}" width="100" alt="IFCITEC">
                        </a>


                    </div>


                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar
                        <ul class="nav navbar-nav">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administrar <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ route('administrarUsuarios') }}">Usuários</a></li>
                                    <li><a href="">Logs</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-left">
                            <li><a href="{{ route('autor') }}">Projeto</a></li>
                            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Comissão Avaliadora</a>
                            <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('comissaoAvaliadora') }}">
                                            Cadastrar-se
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('comissao') }}">
                                            Painel de Comissão Avaliadora
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{ route('voluntario') }}">Voluntário</a></li>
                            <li><a href="{{ route('organizador') }}">Organizador</a></li>
                            <li><a href="{{ route('administrador') }}">Administrador</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nome }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('editaCadastro') }}">
                                            Editar Cadastro
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/material.min.js') }}"></script>
        <script src="{{ asset('js/material-kit.js') }}"></script>
        <script src="{{ asset('js/bootbox.min.js') }}"></script>
        @yield('js')
    </body>
</html>
