@extends('layouts.app')

@section('content')
<div class="container">

	<div class="page-header">
		<h1>Ooops! Um erro inesperado aconteceu</h1>
	</div>

	<div class="row">
		<div class="col-md-12 main main-raised" style="padding-top: 20px;">

			<h3 style="text-align: center; border: 0 !important;">Algo de errado aconteceu aqui, se o erro persistir por favor tira um print dessa tela e entre em contato conosco.</h3>

			<div class="col-md-10 col-md-offset-1">
				<p>{{ $error }}</p>
			</div>

			<div class="col-md-10 col-md-offset-1 text-center">
				<a href="mailto:ifcitec@canoas.ifrs.edu.br" class="confirma btn btn-success">
					<i class="material-icons">mail</i> Entrar em contato
				</a>
				<div class="text-center">
					<a href="#" onclick="window.history.back()" class="btn btn-primary">Voltar</a>
				</div>
			</div>

		</div>

	</div>

</div>

@endsection
