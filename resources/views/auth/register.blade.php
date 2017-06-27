@extends('layouts.app')

@section('css')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="wrapper">
    <div class="container" style="width: 700px; height: 750px; background-color: #eeeeee; border-radius: 10px 20px;">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <center><h2>Cadastro de Participante</h2></center>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <div class="container-fluid">
                        <div class="alert-icon">
                            <i class="material-icons">error_outline</i>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="material-icons">clear</i></span>
                        </button>
                        <b>Ops! </b> Há erros em seu cadastro:
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            <div class="alert alert-warning">
                <div class="container-fluid">
                    <div class="alert-icon">
                        <i class="material-icons">warning</i>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                    </button>
                    <b>ATENÇÃO: </b>É de total resposabilidade do usuário a veracidade dos dados aqui informados, pois estes serão utilizados para a emissão de certificados
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                <div class="content">
                            {{ csrf_field() }}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">face</i>
                        </span>
                        
                        <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" placeholder=" Nome">
                    </div>

                    <br>
                    <div class="col-md-12 col-md-offset-1">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">credit_card</i>
                            </span>
                            <input type="cpf" id="cpf" maxlength="14" OnKeyPress="formatar('###.###.###-##', this)" class="form-control" name="cpf" value="{{ old('cpf') }}" placeholder=" CPF">
                            Caso você não possua um, deixe em branco
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 col-md-offset-1">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">insert_invitation</i>
                            </span>
                            <input type="text" id="exemplo" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 col-md-offset-1">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" placeholder=" Email">
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 col-md-offset-1">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock_outline</i>
                            </span>
                            <input type="password" id="password" class="form-control" name="password" value="{{ old('password') }}" placeholder=" Senha">
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 col-md-offset-1">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">done</i>
                            </span>
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder=" Confirme a senha">
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-offset-6">
                        <input type="submit" class="btn btn-primary" value="REGISTRAR"><br>
                        <br>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function formatar(mascara, documento) {
        var i = documento.value.length;
        var saida = mascara.substring(0, 1);
        var texto = mascara.substring(i)

        if (texto.substring(0, 1) != saida) {
            documento.value += texto.substring(0, 1);
        }

    }
</script>
</body>
@endsection

@section('javascript')

<script>
    $(document).ready(function () {
        $('#exemplo').datepicker({
            format: "DD/MM/yy",
            language: "pt-BR",
            minViewMode: 0;
                    orientation: auto
        });
    });
</script>
@endsection