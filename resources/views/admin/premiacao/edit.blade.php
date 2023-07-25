@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Editar Brinde</h2>
                        </div>
                    </div>
                    <form method="post" action="{{ route('editaBrinde') }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="id_brinde" value="{{ $brinde->id }}">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">assignment</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome</label>
                                        <input type="text" class="form-control" name="nome"
                                            value="{{ $brinde->nome }}" required>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">format_list_numbered</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Quantidade</label>
                                        <input type="number" class="form-control" name="quantidade"
                                            value="{{ $brinde->quantidade }}" required>
                                    </div>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">description</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" required>{{ $brinde->descricao }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .school-type-label {
            margin-top: 3%;
            margin-right: 2%;
        }
    </style>
@endsection

@section('js')
 
@endsection