@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Gerar Vale Lanche</h2>
                    </div>
                </div>
                <form method="post" action="{{ route('valeLanche', $edicao)}}">

                    {{ csrf_field() }}


                    <div class="row" id="selects">
                           <div>
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="form-group label-floating">
                                    <label class="control-label">Número de Dias Que a Feira Acontecerá</label>
                                    <input type="text" class="form-control" name="dias" required>
                                </div>
                            </div>
                           </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button  class="btn btn-primary">Gerar Vale Lanche</button>
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
