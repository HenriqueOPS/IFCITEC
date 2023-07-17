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
                    <a href="{{ route('admin.brindes.novo') }}" class="btn btn-primary btn-round">
                        <i class="material-icons">add</i> Adicionar Brindes
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Brinde</th>
                            <th>Descrição</th>
                            <th>Quandtidade</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($brindes as $i => $brinde)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $brinde['nome'] }}</td>
                            <td>{{ $brinde['descricao'] }}</td>
                            <td>{{ $brinde['quantidade'] }}</td>
                            <td class="td-actions text-right">
                                <a href="javascript:void(0);" class="modalBrinde" data-toggle="modal" data-target="#modal-brinde" data-brinde="{{ $brinde['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{ route('admin.brindes.editar', $brinde['id']) }}"><i class="material-icons">edit</i></a>
                                   </td>
                                   
                        </tr>
                        @endforeach
                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="modal-brinde" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal-brinde">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nomeBrindeModal"></h5>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">assignment</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="descricaoBrindeModal"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">format_list_numbered</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="quantidadeBrindeModal"></span>
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
   document.getElementById('nav-brindes').classList.add('active');
    $('.modalBrinde').click(function(){
        // Recupera o id do brinde
        var idBrinde = $(this).data('brinde');

        // Monta a URL de consulta
        var urlConsulta = '/brinde/dados-brinde/' + idBrinde;

        // Faz a consulta via Ajax
        $.get(urlConsulta, function (res){
            console.log(res);

            // Altera o DOM
            $("#nomeBrindeModal").text(res.dados.nome);
            $("#descricaoBrindeModal").text(res.dados.descricao);
            $("#quantidadeBrindeModal").text(res.dados.quantidade);

            // Abre o modal
            $("#modal-brinde").modal();
        });
    });
    @if(session('success'))
            alert("{{ session('success') }}");
    @endif
</script>
@endsection
