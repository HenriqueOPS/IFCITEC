@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">

<style>
    .container-aviso{
    	max-width: 800px;
    	margin-top: 100px;
    }
    .box-logo{padding: 0 !important;}

</style>

@endsection

@section('content')
<div class="container container-aviso">
    <div class="row">
        
        <div class="col-md-4 col-md-offset-4 col-xs-10 col-xs-offset-1">
            <div class="content text-center box-logo">
                <a class="btn btn-simple btn-just-icon">
                    <img src="{{ asset('img/logonormal.png') }}" title="IFCITEC" height="110" />
                </a>
            </div>
        </div>

    </div>

    <div class="row">
        
        <div class="col-md-12">
            <h3 class="h3 text-center">A VI IFCITEC ocorrerá no dia 19 de Setembro</h3>
            <h4 class="h4 text-center">Aguarde, em breve maiores informações!</h4>
        </div>

    </div>


</div>
@endsection


