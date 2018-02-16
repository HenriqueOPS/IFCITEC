@extends('layouts.app')

@section('css')
<link href="{{ asset('css/organization.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Painel administrativo</h2>
        </div>

        <div class="col-md-3" >
            <ul class="nav nav-pills nav-pills-primary"  role="tablist">
                <li class="active">
                    <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">adjust</i>
                        Edições
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">account_balance</i>
                        Escolas
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
                    <thead id="0">
                    <div id="0">
                        <div class="col-md-12">
                            <a href="{{ route('cadastroEdicao') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Edição
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Ano</th>
                        <th>Período de Inscrição</th>
                        <th>Período de Homologação</th>
                        <th>Período de Avaliação</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>


                    <tbody id="0">

                        @foreach($edicoes as $edicao)

                        <tr>
                            <td class="text-center">0</td>
                            <td>{{$edicao->ano}}</td>
                            <td>{{$edicao->inscricao_abertura}} - {{$edicao->inscricao_fechamento}}</td>
                            <td>{{$edicao->homologacao_abertura}} - {{$edicao->homologacao_fechamento}}</td>
                            <td>{{$edicao->avaliacao_abertura}} - {{$edicao->avaliacao_fechamento}}</td>
                            <td class="td-actions text-right">
                                <a href="{{route( 'edicao',$edicao->id) }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="#{{$edicao->id}}"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                        @endforeach

                    </tbody>

                    <thead id="1">
                    <div id="1">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroEscola') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Escola
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Escola</th>
                        <th>Município</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="1">

                    @foreach($escolas as $i => $escola)

                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $escola->nome_curto }}</td>
                            <td>{{ $escola->municipio }}</td>
                            <td>{{ $escola->email }}</td>
                            <td>{{ $escola->telefone }}</td>
                            <td class="td-actions text-right">

                                <a class="modalEscola" id-escola="{{ $escola->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>


                                <a href="{{ route('escola', $escola->id) }}"><i class="material-icons">edit</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


<!-- Dados da Escola -->
<div id="myModal" class="modal fade bd-example-modal-lg" role="dialog">
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="application/javascript">
$('.modalEscola').click(function(){

    //recupera o id da escola
    var idEscola = $(this).attr('id-escola');

    //monta a url de consulta
    var urlConsulta = '/escola/dados-escola/'+idEscola;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (data){

        //monta a string do endereço
        var endereco =  data.endereco+", "+
                        data.numero+", "+
                        data.bairro+", "+
                        data.municipio+" - "+
                        data.uf;


        //altera o DOM
        $("#nome-curtoModal").html(data.nome_curto);
        $("#nome-completoModal").html(data.nome_completo);
        $("#emailModal").html(data.email);
        $("#telefoneModal").html(data.telefone);
        $("#enderecoModal").html(endereco);
        $("#cepModal").html(data.cep);

        //abre a modal
        $("#myModal").modal();

    });

})

$(document).ready(function () {

    hideBodys();
    hideHeads();
    $('tbody[id=0]').show();
    $('thead[id=0]').show();
    $('div[id=0]').show();
        $('.tab').click(function (e) {
            var target = $(this)[0];
            hideBodys();
            hideHeads();
            $('tbody[id='+target.id+']').show();
            $('thead[id='+target.id+']').show();
            $('div[id='+target.id+']').show();
        });

});

function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
    $('tbody[id=2]').hide();
    $('tbody[id=3]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
}
function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('thead[id=3]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
}
</script>
@endsection

