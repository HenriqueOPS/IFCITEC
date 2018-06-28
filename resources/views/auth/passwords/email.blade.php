@extends('layouts.app')

@section('css')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container" style="width: 600px; height: 300px; margin-top: 100px; background-color: #FFF; border-radius: 10px 20px;">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Redefinir Senha</h2>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ url('/password/email') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                             <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-offset-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons">send </i> Enviar link de redefinição
                                </button>
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
    @endsection
