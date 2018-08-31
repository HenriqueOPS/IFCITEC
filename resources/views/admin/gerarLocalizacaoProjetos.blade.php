@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">

@endsection


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Gerar Localização de Projetos</h2>
                    </div>
                </div>
                <form method="post" action="{{ route('cadastroTarefa')}}">

                    {{ csrf_field() }}


                    <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Bloco</label>
                                    <input type="text" class="form-control" name="bloco" required>
                                </div>
                            </div>

        
                            <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                  <input name="de" type="number" class="form-control" placeholder="De... (Sala)">
                                </div>
                                <div class="col-md-4 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                  <input name="ate" type="number" class="form-control" placeholder="Até... (Sala)">
                                </div>
                            </div>


                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero de Projetos Por Sala</label>
                                    <input type="text" class="form-control" name="num" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Gerar</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection