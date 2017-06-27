@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Completando o Cadastro..</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{  route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="nome" value="{{ $nome }}" disabled>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email }}" disabled required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">CPF</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}" required autofocus>

                                @if ($errors->has('cpf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cpf') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nascimento</label>

                            <div class="col-md-6">
                                <input id="name" type="date" class="form-control" name="dt_nascimento" value="{{ old('dt_nascimento') }}" required autofocus>

                                @if ($errors->has('dt_nascimento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            Inscrever
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
