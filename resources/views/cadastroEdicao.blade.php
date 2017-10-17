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
                        <h2>Cadastro de Edição</h2>
                    </div>
                </div>
                <form name="f1" method="POST" action="{{ route('cadastroEdicao')}}">

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">event_note</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Ano</label>
                                    <input type="number" class="form-control" name="ano" required>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Edição</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período da feira</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período das inscrições de projetos</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período das inscrições de homologadores</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período das inscrições de avaliadores</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período das inscrições de voluntários</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período das homologações</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><hr>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                    <h3>Período das avaliações</h3>
                                </div>
                                <div class="col-md-4 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Início</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-md-offset-2 col-xs-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons">today</i>
                                        </span>
                                        <div class="form-group ">
                                            <label class="control-label">Fim</label>
                                            <input type="datetime-local" class="form-control datepicker" name="name"  required>
                                        </div>
                                    </div>
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
