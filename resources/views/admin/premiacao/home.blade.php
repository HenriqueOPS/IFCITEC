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
                        <i class="material-icons">add</i> Adicionar Prêmio
                    </a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Brinde</th>
                            <th>Descrição</th>
                            <th>Tamanho</th>
                            <th>Quantidade</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($brindes as $i => $brinde)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $brinde['nome'] }}</td>
                            <td>{{ $brinde['descricao'] }}</td>
                            <td>{{ $brinde['tamanho'] }}</td>
                            <td>{{ $brinde['quantidade'] }}</td>
                            <td class="td-actions text-right">
            <a href="javascript:void(0);" class="modalBrinde" data-toggle="modal" data-target="#modal-brinde" data-brinde="{{ $brinde['id'] }}"><i class="material-icons blue-icon">balance</i></a>
            <a href="javascript:void(0);" onclick="abrirModalAdicionar({{ $brinde['id'] }})"><i class="material-icons">add_circle</i></a>
            <a href="javascript:void(0);" onclick="abrirModalDecrementar({{ $brinde['id'] }})"><i class="material-icons">remove_circle</i></a>       </td>
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
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">straighten</i>
                    </span>
                    <div class="form-group label-floating">
                        <span id="tamanho"></span>
                    </div>
                </div>
                <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">date_range</i>
                </span>
                <div class="form-group label-floating">
                    <span id="dataCriacao"></span>
                </div>
            </div>
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">update</i>
                        </span>
                        <div class="form-group label-floating">
                            <span id="ultimaAtualizacao"></span>
                        </div>
                 </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-adicionar-quantidade" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal-adicionar-quantidade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-adicionar-quantidade" action="{{ route('admin.premiacao.aumento') }}" method="post">
            {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-adicionar-quantidade-title">Adicionar Quantidade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="quantidade">Quantidade a Adicionar</label>
                        <input type="number" class="form-control" name="quantidade" required>
                        <input type="hidden" name="brinde_id" id="brinde_id_adicionar" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-decrementar-quantidade" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal-decrementar-quantidade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-decrementar-quantidade" action="{{ route('admin.premiacao.decremento') }}" method="post">
            {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-decrementar-quantidade-title">Decrementar Quantidade</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="quantidade">Quantidade a Decrementar</label>
                        <input type="number" class="form-control" name="quantidade" required>
                        <input type="hidden" name="brinde_id" id="brinde_id_decrementar" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Decrementar</button>
                </div>
            </form>
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
            $("#tamanho").text(res.dados.tamanho);
            $("#dataCriacao").text(res.dados.created_at);
            $("#ultimaAtualizacao").text(res.dados.updated_at);


            // Abre o modal
            $("#modal-brinde").modal();
        });
    });
    @if(session('success'))
            alert("{{ session('success') }}");
    @endif
    function abrirModalAdicionar(idBrinde) {
    // Abra o modal de adicionar quantidade usando o ID do brinde
    $("#brinde_id_adicionar").val(idBrinde);
    $("#modal-adicionar-quantidade").modal();
}

function abrirModalDecrementar(idBrinde) {
    // Abra o modal de decrementar quantidade usando o ID do brinde
    $("#brinde_id_decrementar").val(idBrinde);
    $("#modal-decrementar-quantidade").modal();
}
</script>
@endsection
