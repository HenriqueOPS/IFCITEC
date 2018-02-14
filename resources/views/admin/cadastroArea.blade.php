@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Cadastro de Área</h2>
                    </div>
                </div>
                <form name="f1" method="GET" action="{{ route('cadastroSucesso')}}">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nível</label>
                                    <select class="form-control" id="">
                                        <option>Fundamental</option>
                                        <option>Ensino Médio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome da Área</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Cadastrar</button>

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

