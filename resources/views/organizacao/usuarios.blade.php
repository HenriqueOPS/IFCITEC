@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            <div id="page" class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary"  role="tablist">
                <li>
                    <a href="{{route('organizador')}}">
                        <i class="material-icons">account_balance</i>
                        Escolas
                    </a>
                </li>
                <li>
                    <a href="{{route('organizacao.projetos')}}">
                        <i class="material-icons">list_alt</i>
                        Listar Projetos
                    </a>
                </li>
                <li>
                    <a href="{{route('organizacao.presenca')}}">
                        <i class="material-icons">account_circle</i>
                        Presença
                    </a>
                </li>
                <li>
                    <a href="{{route('organizacao.relatoriosEdicao')}}">
                        <i class="material-icons">description</i>
                        Relatórios
                    </a>
                </li>
                <li class="active">
                    <a href="{{route('organizacao.usuarios')}}">
                        <i class="material-icons">person</i>
                        Usuários
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                    <table class="table">
                <thead id="5">
                    <div id="5">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuários</th>
                            <th>E-mail</th>
                        </tr>
                    </div>
                    </thead>

                    <tbody id="5">
                        @foreach($usuarios as $key=>$usuario)
                        <tr>
                            <td class="text-center">{{$key + 1}}</td>
                            <td>{{$usuario->nome}}</td>
                            <td>{{$usuario->email}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Usuário -->
<div id="ModalDeleteUsuário" class="modal fade bd-example-modal-lg" role="dialog4" aria-labelledby="ModalDeleteUsuário">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Usuário</h5>
            </div>

            <div class="modal-body">
                <span>Para deletar o usuário, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="passwordDeleteUsuário" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal -->
@endsection

@section('js')
<script type="application/javascript">
    $('.exclusaoUsuario').click(function(){
        var idUsuario= $(this).attr('id-usuario');

        $("#ModalDeleteUsuário").modal();

        $('.excluir').click(function(){
            var urlConsulta = '.././usuario/exclui-usuario/'+idUsuario+'/'+$('#passwordDeleteUsuário').val();

            $.get(urlConsulta, function (res){
                if(res == 'true'){
                    bootbox.alert("Usuário excluído com sucesso");
                    window.location.reload();
                }else{
                    bootbox.alert("Senha incorreta");
                    window.location.reload();
                }
            });

        });

    });
</script>


@endsection
