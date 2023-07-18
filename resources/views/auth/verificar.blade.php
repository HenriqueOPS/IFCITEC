@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 60px; ">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <br>
                    <h3 class="text-center" style="width: 90%; margin: auto; border-bottom: 1px solid #ccc;">
                        Confirme seu email
                    </h3>
                    <br>
                    <div class="content box-logo text-center">
                      
                            <img src="{{ asset('img/logonormal.png') }}" title="IFCITEC" height="110" />
                
                    </div>
                    <div class="panel-body">
                        @if (isset($success))
                            <div class="alert alert-success">
                                {{ $success }}
                            </div>
                        @endif

                        @if (isset($error))
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong>
                                {{ $error }}
                            </div>
                        @endif
                    </div>
                    <p class="text-center" style="font-size: 16pt; font-weight: 300; padding: 5pt;">
                        Para proseguir, você deve confirmar sua conta atraves de um link enviado ao seu email.
                    </p>
                    <div class="text-center" style="padding-bottom: 25pt;">
                        <button class="btn btn-primary" id="reenviar-email">Clique aqui para reenviar o email</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('reenviar-email').addEventListener('click', () => {
            $.get('{{ route('auth.enviar.email', $idPessoa) }}');
        });
    </script>
@endsection
