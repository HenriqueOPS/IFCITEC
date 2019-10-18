@extends('layouts.app')

@section('content')
	<div class="container">

		<div class="page-header">
			<h1>Erros - laravel.log</h1>

		</div>

		<div class="row">

			<div class="col-md-12 main main-raised">

				<pre style="font-size: 10px;">@php echo file_get_contents('../storage/logs/laravel.log'); @endphp</pre>

			</div>

		</div>

	</div>

@endsection
