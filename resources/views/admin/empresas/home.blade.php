@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2>Painel administrativo</h2>
        </div>
        @include('partials.admin.navbar')
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12 main main-raised">
            <div class="list-projects">
                <div class="col-md-3">
                    <a href="{{ route('admin.empresas.nova') }}" class="btn btn-primary btn-round">
                        <i class="material-icons">add</i> Adicionar Empresa
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Empresa</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empresas as $i => $empresa)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $empresa['nome_curto'] }}</td>
                            <td>{{ $empresa['email'] }}</td>
                            <td>{{ $empresa['telefone'] }}</td>
                            <td class="td-actions text-right">
                                <a href="javascript:void(0);" class="modalEmpresa" data-toggle="modal" data-target="#modal-escola" data-empresa="{{ $empresa['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{ route('admin.empresas.editar', $empresa['id']) }}"><i class="material-icons">edit</i></a>
                                   </td>
                                   
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="modal-escola" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal-escola">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nome-curtoModal"></h5>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">assignment</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="nome-completoModal"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">mail</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="emailModal"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">phone</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="telefoneModal"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">location_on</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="enderecoModal"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">markunread_mailbox</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="cepModal"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>




@endsection

@section('css')
    <style>
        
    </style>
@endsection


@section('js')
<script>
	document.getElementById('nav-empresas').classList.add('active');
    $('.modalEmpresa').click(function(){
    // Recupera o id da empresa
    var idEmpresa = $(this).data('empresa');

    // Monta a URL de consulta
    var urlConsulta = '/empresa/dados-empresa/' + idEmpresa;

    // Faz a consulta via Ajax
    $.get(urlConsulta, function (res){
        console.log(res);

        // Altera o DOM
        $("#nome-curtoModal").text(res.dados.nome_curto);
        $("#nome-completoModal").text(res.dados.nome_completo);
        $("#emailModal").text(res.dados.email);
        $("#telefoneModal").text(res.dados.telefone);
        $("#enderecoModal").text(res.data.endereco);
        $("#cepModal").text(res.data.cep);

        // Abre o modal
        $("#modal-escola").modal();
    });
});
</script>
@endsection
