@extends('layouts.app')

@section('content')
<div class="container" >

	@if(!(\App\Edicao::getEdicaoId()))

		<div class="page-header">
			<h3>Olá {{ Auth::user()->nome }}</h3>

			<div class="alert alert-warning" style="background: #bd8c0e">
				<strong>Ainda não abriram as inscrições!</strong> acompanhe a gente por nosso <a href="http://ifcitec.canoas.ifrs.edu.br">site</a> e por nossa <a href="https://www.instagram.com/ifcitec/">página no Instagram</a> para quaisquer novidades.
			</div>
		</div>

	@else

		<div class="page-header">
			<h3>Olá, {{ Auth::user()->nome }}</h3>

					{!! $aviso !!}

		</div>
					
		<div class="row" style="height:1000px;" >
		
			<div class="col-md-4 main main-raised" style="padding-top: 20px;height:100%;">
						{!! $instagram1 !!}

			</div>
			<div class="col-md-4 main main-raised " style="padding-top: 20px;height:100%;">
						
						{!! $instagram2 !!}

			</div>
			<div class="col-md-4 main main-raised" style="padding-top: 20px;height:100%;">
						
						{!! $instagram3 !!}

						
			</div>
			</div>
					
	@endif

</div>

@endsection
