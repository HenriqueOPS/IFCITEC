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
                        <center><h2>Cadastro realizado com sucesso!</h2></center>
                    </div>
                </div>
                <br><br><br>
                <form name="f1" method="GET" action="{{ Redirect::back()}}">
                <div class="row">
                    <div class="col-md-offset-1">
                        <button class="btn btn-primary btn-fab btn-fab-mini btn-round">
                            <i class="material-icons">arrow_back</i>
                        </button>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
@endsection

