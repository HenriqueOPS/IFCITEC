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

        <div class="col-md-9 " >
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
                <li>
                    <a href="dashboard" id="2" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">school</i>
                        Níveis
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="3" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">brightness_auto</i>
                        Áreas
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

                        @foreach($edicoes as $id => $edicao)

                        <tr>
                            <td class="text-center">{{$id}}</td>
                            <td>{{$edicao->ano}}</td>
                            <td>{{$edicao->inscricao_abertura}} - {{$edicao->inscricao_fechamento}}</td>
                            <td>{{$edicao->homologacao_abertura}} - {{$edicao->homologacao_fechamento}}</td>
                            <td>{{$edicao->avaliacao_abertura}} - {{$edicao->avaliacao_fechamento}}</td>
                            <td class="td-actions text-right">
                                <a href="{{route('edicao',$edicao->id) }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{route('editarEdicao',$edicao->id)}}"><i class="material-icons">edit</i></a>
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
                            <td></td>
                            <td>{{ $escola->email }}</td>
                            <td>{{ $escola->telefone }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalEscola" id-escola="{{ $escola->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('escola', $escola->id) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusao" id-escola="{{ $escola->id }}"><i class="material-icons blue-icon">close</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                    <thead id="2">
                    <div id="2">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroNivel') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Nível
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nível</th>
                        <th>Descrição</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="2">

                    @foreach($niveis as $i => $nivel)

                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $nivel->nivel }}</td>
                            <td>{{ $nivel->descricao }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalNivel" id-nivel="{{ $nivel->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('nivel', $nivel->id) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoNivel" id-nivel="{{ $nivel->id }}"><i class="material-icons blue-icon">close</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                    <thead id="3">
                    <div id="3">
                        <div class="col-md-3">
                            <a href="{{ route('cadastroArea') }}" class="btn btn-primary btn-round">
                                <i class="material-icons">add</i> Adicionar Área do Conhecimento
                            </a>
                        </div>
                    </div>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Área do Conhecimento</th>
                        <th>Descrição</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="2">

                    @foreach($areas as $i => $area)

                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $area->area_conhecimento }}</td>
                            <td>{{ $area->descricao }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalArea" id-area="{{ $area->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('area', $area->id) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusao" id-area=""><i class="material-icons blue-icon">close</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>




<!-- Modal Escola -->
<div id="myModal" class="modal">
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
<!-- Fim Modal Escola -->

<!-- Modal Delete Escola -->
<div id="ModalDelete" class="modal">
    <div class="modal-dialog" role="document1">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Escola</h5>
            </div>

            <div class="modal-body">
                <span>Para deletar a escola, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Delete Escola -->

<!-- Modal Nível -->
<div id="nivelModal" class="modal">
  <div class="modal-dialog" role="document2">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titleNivelModal"></h5>
        </div>
        <div class="modal-body">

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">assignment</i>
                </span>
                <div class="form-group label-floating">
                    <span id="max_chModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">mail</i>
                </span>
                <div class="form-group label-floating">
                    <span id="min_chModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">phone</i>
                </span>
                <div class="form-group label-floating">
                    <span id="descricaoModal"></span>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
  </div>
</div>
<!-- Fim Modal Nível -->

<!-- Modal Delete Nível -->
<div id="ModalDeleteNivel" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Nível</h5>
            </div>

            <div class="modal-body">
                <span>Para deletar o nível, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Delete Nível -->

@endsection

@section('js')

    <!-- Modal Delete Escola -->
    <script type="application/javascript">
    $('.exclusao').click(function(){
        var idEscola = $(this).attr('id-escola');

        $("#ModalDelete").modal();

        $('.excluir').click(function(){
            var urlConsulta = './escola/exclui-escola/'+idEscola+'/'+$('#password').val();
            $.get(urlConsulta, function (res){
                if(res == 'true'){
                    alert("Escola excluida");
                    location.href = './administrador';
                }else{
                    alert("Senha incorreta");
                }

            });
        });

    });
    </script>
    <!-- Fim Modal Delete Escola -->

    <!-- Modal Delete Nível -->
    <script type="application/javascript">
    $('.exclusaoNivel').click(function(){
        var idNivel= $(this).attr('id-nivel');

        $("#ModalDeleteNivel").modal();

        $('.excluir').click(function(){
            var urlConsulta = './nivel/exclui-nivel/'+idNivel+'/'+$('#password').val();
            $.get(urlConsulta, function (res){
                if(res == 'true'){
                    alert("Nível excluido");
                    location.href = './administrador';
                }else{
                    alert("Senha incorreta");
                }

            });
        });

    });
    </script>
    <!-- Fim Modal Delete Nível -->

    <!-- Modal Escola -->
    <script type="application/javascript">
    $('.modalEscola').click(function(){

        //recupera o id da escola
        var idEscola = $(this).attr('id-escola');

        //monta a url de consulta
        var urlConsulta = './escola/dados-escola/'+idEscola;
        //faz a consulta via Ajax
        $.get(urlConsulta, function (res){

            console.log(res);
            //monta a string do endereço
            let endereco = '';

            if(res.dados.endereco_id) {
                res.data.endereco ? endereco += res.data.endereco + ", " : endereco += '';
                res.data.numero ? endereco += res.data.numero + ", " : endereco += '';
                res.data.bairro ? endereco += res.data.bairro + ", " : endereco += '';
                res.data.municipio ? endereco += res.data.municipio + ", " : endereco += '';
                res.data.uf ? endereco += res.data.uf + ", " : endereco += '';
            }

            //altera o DOM
            $("#nome-curtoModal").html(res.dados.nome_curto);
            $("#nome-completoModal").html(res.dados.nome_completo);
            $("#emailModal").html(res.dados.email);
            $("#telefoneModal").html(res.dados.telefone);
            $("#enderecoModal").html(endereco);

            if(res.data)
                $("#cepModal").html(res.data.cep);

            //abre a modal
            $("#myModal").modal();

        });

    })
    </script>
    <!-- Fim Modal Escola -->

    <!-- Modal Nível -->
    <script type="application/javascript">
    $('.modalNivel').click(function(){

        var idNivel = $(this).attr('id-nivel');

        //monta a url de consulta
        var urlConsulta = './nivel/dados-nivel/'+idNivel;
        //faz a consulta via Ajax
        $.get(urlConsulta, function (res){

            console.log(res);

            //altera o DOM
            $("#titleNivelModal").html(res.dados.nivel);
            $("#max_chModal").html(res.dados.max_ch);
            $("#min_chModal").html(res.dados.min_ch);
            $("#descricaoModal").html(res.dados.descricao);

            //abre a modal
            $("#nivelModal").modal();

        });

    })
    </script>
    <!-- Fim Modal Nível -->

    <!-- Table Nav -->
    <script type="application/javascript">
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
    <!-- Fim Table Nav -->

@endsection

