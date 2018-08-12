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
        @yield('css')

		@if (!env('APP_DEBUG'))

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_ANALYTICS_ID')}}"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '{{env('GOOGLE_ANALYTICS_ID')}}');

		@if (Auth::user())
		gtag('set', {'user_id': '{{ Auth::user()->id }} - {{ Auth::user()->nome }}'}); // Defina o ID de usuário usando o user_id conectado.
		@endif
		</script>

		<!-- Google Tag Manager -->
		<script>
			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
						new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
					j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
					'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','{{env('TAG_MANAGER_ID')}}');</script>
		<!-- End Google Tag Manager -->

		@endif

		<!-- Import JQuery -->
		<script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{env('TAG_MANAGER_ID')}}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

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

								@if(\App\Edicao::consultaPeriodo('Comissão') || Auth::user()->temFuncao('Administrador'))
									<li><a href="{{route('comissao')}}">Comissão Avaliadora</a></li>
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
											<a href="{{ route('editarCadastro') }}">
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

			<div id="gtm" class="container"></div>

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
