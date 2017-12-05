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
                        <a class="navbar-brand" href="#">
                            <img src="{{ asset('img/logo.png') }}" width="100" alt="IFCITEC">
                        </a>

                        
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <!-- Authentication Links -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Administrar <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="">Usuários</a></li>
                                    <li><a href="">Logs</a></li>
                                </ul>
                            </li>
                        </ul>
                        
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Função <span class="caret"></span></a>

                                <ul class="dropdown-menu" role="menu">
                                    @if (Auth::user()->temFuncao('Administrador'))
                                    <li><a href="{{ route('administrador') }}">Administrador</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Organizador'))
                                    <li><a href="{{ route('organizador') }}">Organizador</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Recepção'))
                                    <li><a href="{{ route('administrador') }}">Recepção</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Usuário'))
                                    <li><a href="{{ route('administrador') }}">Usuário</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Avaliador'))
                                    <li><a href="{{ route('administrador') }}">Avaliador</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Revisor'))
                                    <li><a href="{{ route('administrador') }}">Revisor</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Autor'))
                                    <li><a href="{{ route('autor') }}">Autor</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Orientador'))
                                    <li><a href="{{ route('administrador') }}">Orientador</a></li>
                                    @endif

                                    @if (Auth::user()->temFuncao('Coorientador'))
                                    <li><a href="{{ route('administrador') }}">Coorientador</a></li>
                                    @endif
                                </ul>
                            </li>
                            
                            


                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->nome }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a>
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
        @yield('js')
    </body>
</html>
