@extends('layouts.app')

@section('content')
	<br><br><br>
	<div class="container">
		<div class="row">

			<div class="col-md-8 col-md-offset-2 col-sm-12">
				<div class="main main-raised">

					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<center><h2>Olá Voluntário(a)! Sua tarefa nessa edição da IFCITEC é: {{$tarefa->first()->tarefa}}</h2></center>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
@endsection
