@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Cadastro de Brinde</h2>
                        </div>
                    </div>
                    <form method="post" action="{{ route('admin.brindes.cadastrar') }}">

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">redeem</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nome</label>
                                        <input type="text" class="form-control" name="nome" required>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">format_list_numbered</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Quantidade Inicial do Estoque</label>
                                        <input type="number" class="form-control" name="quantidade" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">description</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Descrição</label>
                                        <textarea class="form-control" name="descricao" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">straighten</i>
                                    </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Tamanho</label>
                                        <input type="text" class="form-control" name="tamanho" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons">local_shipping</i>
                                    </span>
                                    <div class="form-group label-floating">
                                    <label for="origem_destino">Origem do Brinde</label>
                        <input type="text" class="form-control" name="origem_destino" required>
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
