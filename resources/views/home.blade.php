@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">

    <div class="page-header">
	    <h1>Olá {{ Auth::user()->nome }}</h1>  

	</div>

</div>

@endsection
