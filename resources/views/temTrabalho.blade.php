@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <center><h2>Não foi possível efetuar sua inscrição pois você já possui trabalho(s) na feira!</h2></center>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>
</body>
@endsection