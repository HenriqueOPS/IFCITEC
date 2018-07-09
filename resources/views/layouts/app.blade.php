<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IFCITEC') }}</title>

        <!-- Fonts and icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/material-kit.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        @yield('css')

		<!-- Import JQuery -->
		<script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <div id="app">
			@if (Auth::guest())
			@else

				<nav class="navbar navbar-default navbar-static-top" role="navigation">
					<div class="container">


						<div class="navbar-header">
							<a class="navbar-brand" href="{{ route('home') }}">
								<img src="{{ asset('img/logo.png') }}" width="100" alt="IFCITEC">
							</a>

							<button type="button" class="navbar-toggle" data-toggle="collapse" >
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>


						<div class="collapse navbar-collapse" id="navbarNav">

							<!-- Left Side Of Navbar -->
							<ul class="nav navbar-nav navbar-left">
								<li><a href="{{ route('autor') }}">Projeto</a></li>

								@if((Auth::user()->temFuncao('Avaliador') || Auth::user()->temFuncao('Homologador')))
									<li><a href="{{ route('comissaoHome') }}" class="dropdown-toggle" data-toggle="dropdown" >Comissão Avaliadora</a></li>
								@endif

								@if(\App\Edicao::consultaPeriodo('Comissão') || Auth::user()->temFuncao('Administrador'))
									<li><a href="#" class="dropdown-toggle" data-toggle="dropdown" >Comissão Avaliadora</a>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a href="{{route('comissao')}}">Cadastrar-se</a>
											</li>
										</ul>
									</li>
								@endif

								@if(\App\Edicao::consultaPeriodo('Voluntário') || Auth::user()->temFuncao('Administrador'))
									<li><a href="{{ route('voluntario') }}">Voluntário</a></li>
								@endif

								@if(Auth::user()->temFuncao('Organizador') || Auth::user()->temFuncao('Administrador'))
									<li><a href="{{ route('organizador') }}">Organizador</a></li>
								@endif

								@if(Auth::user()->temFuncao('Administrador'))
									<li><a href="{{ route('administrador') }}">Administrador</a></li>
								@endif

							</ul>

							<ul class="nav navbar-nav navbar-right">

								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										{{ Auth::user()->nome }} <span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
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
							</ul>
						</div>
					</div>
				</nav>
			@endif

            @yield('content')

        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/material.min.js') }}"></script>
        <script src="{{ asset('js/bootbox.min.js') }}"></script>

		<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/material.min.js') }}"></script>

		<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
		<script src="{{ asset('js/material-kit.js') }}" type="text/javascript"></script>

		<script>
			//XGH: por motivos de Descubra! o bootstrap não fecha o menu  mobile

			var mobileNavFlag = true;
			$(document).on('click','button.navbar-toggle',function(e) {
				if(mobileNavFlag){
					$('#navbarNav').collapse('show');
				}else{
					$('#navbarNav').collapse('hide');
				}

				mobileNavFlag = !mobileNavFlag;
			});
		</script>

		@yield('partials')

        @yield('js')

    </body>
</html>
