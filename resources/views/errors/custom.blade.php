@extends('layouts.app')

@section('content')
<div class="container">

	<div class="page-header">
		<h1>IFCITEC Informa</h1>
	</div>

	<div class="row">
		<div class="col-md-12 main main-raised" style="padding-top: 20px;">

			<h3 style="text-align: center; border: 0 !important;">Nossa plataforma encontra-se instável.<br/>
				Se o erro persistir, por favor tire um print desta tela e nos envie.</h3>

			<div class="col-md-10 col-md-offset-1">
				<p>ID do erro: {{ $erro_id }}</p>
			</div>

			<div class="col-md-10 col-md-offset-1 text-center">
				<a href="mailto:ifcitec@canoas.ifrs.edu.br" class="confirma btn btn-success">
					<i class="material-icons">mail</i> Entrar em contato por e-mail
				</a>
				<a href="https://www.instagram.com/ifcitec" class="confirma btn btn-success">
					<i class="material-icons">mail</i> Entrar em contato pelo Instagram
				</a>
				<div class="text-center">
					<a href="#" onclick="window.history.back()" class="btn btn-primary">Voltar</a>
				</div>
			</div>

		</div>

	</div>

</div>

@endsection
