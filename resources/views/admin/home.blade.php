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

        <div id="page" class="col-md-10 col-xs-offset-2">
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
                <li>
                    <a href="dashboard" id="4" class="tab" role="tab" data-toggle="tab">
                        <i class="material-icons">list_alt</i>
                        Listar Projetos
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
                            <td class="text-center">{{$id+1}}</td>
                            <td>{{  \App\Edicao::numeroEdicao($edicao['ano']) }}</td>
                            <td>{{$edicao['inscricao_abertura']}} - {{$edicao['inscricao_fechamento']}}</td>
                            <td>{{$edicao['homologacao_abertura']}} - {{$edicao['homologacao_fechamento']}}</td>
                            <td>{{$edicao['avaliacao_abertura']}} - {{$edicao['avaliacao_fechamento']}}</td>
                            <td class="td-actions text-right">
                                <a href="javascript:void(0);" class="modalEdicao"  id-edicao="{{ $edicao['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>
                                <a href="{{route('editarEdicao',$edicao['id'])}}"><i class="material-icons">edit</i></a>
                                <a href="javascript:void(0);" class="exclusaoEdicao" id-edicao="{{ $edicao['id'] }}"><i class="material-icons blue-icon">delete</i></a>
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
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $escola['nome_curto'] }}</td>
                            <td></td>
                            <td>{{ $escola['email'] }}</td>
                            <td>{{ $escola['telefone'] }}</td>



                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalEscola"  data-toggle="modal" data-target="#modal0" id-escola="{{ $escola['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('escola', $escola['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusao" id-escola="{{ $escola['id'] }}"><i class="material-icons blue-icon">delete</i></a>
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
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $nivel['nivel'] }}</td>
                            <td>{{ $nivel['descricao'] }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalNivel" data-toggle="modal" data-target="#modal1" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('nivel', $nivel['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoNivel" id-nivel="{{ $nivel['id'] }}"><i class="material-icons blue-icon">delete</i></a>
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
                        <th>Nível</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody id="3">

                    @foreach($niveis as $nivel)
                    @foreach($areas as $i => $area)
                    @if($area['nivel_id'] == $nivel['id'])
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $area['area_conhecimento'] }}</td>

                            <td>{{ $nivel['nivel'] }}</td>

                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalArea" data-toggle="modal" data-target="#modal2" id-area="{{ $area['id'] }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('area', $area['id']) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusaoArea" id-area="{{ $area['id'] }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    @endforeach

                    </tbody>

                    <thead id="4">
                    <div id="4">

                    </div>

                    </thead>

                    <tbody id="4">
                        @foreach($projetos as $i => $projeto)

                        <div id="4" class="project">
                        <div class="project-title">
                             <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                        </div>
                        <div class="project-info">
                            Integrantes:
                            @foreach ($autor as $dadosAutor)
                            @if($dadosAutor->projeto_id == $projeto->id)
                            {{$dadosAutor->nome}},
                            @endif
                            @endforeach

                            @foreach ($orientador as $dadosOrientador)
                            @if($dadosOrientador->projeto_id == $projeto->id)
                            {{$dadosOrientador->nome}},
                            @endif
                            @endforeach

                            @foreach($coorientador as $dadosCoorientador)
                            @if($dadosCoorientador->projeto_id == $projeto->id)
                            {{$dadosCoorientador->nome}},
                            @endif
                            @endforeach
                        </div>
                        </div>

                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Delete Área -->
<div id="ModalDeleteArea" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalDeleteArea">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Área</h5>
            </div>

            <div class="modal-body">
                <span>Para deletar a área, confirme sua senha.</span>
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
<!-- Fim Modal -->

<!-- Modal Delete Edição -->
<div id="ModalDeleteEdicao" class="modal fade bd-example-modal-lg" role="dialog4" aria-labelledby="ModalDeleteEdicao">
    <div class="modal-dialog" role="document4">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Edição</h5>
            </div>

            <div class="modal-body">
                <span>Para deletar a edição, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="password2" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal -->

<!-- Modal -->
<div  id="modal3" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="modal3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="anoModal"></h5>
        </div>
        <div class="modal-body">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="pinsModal"></span>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="phomModal"></span>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="pcreModal"></span>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="pavaModal"></span>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="pvolModal"></span>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="piahModal"></span>
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">today</i>
                </span>
                <div class="form-group label-floating">
                    <span id="testeModal"></span>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>
</div>
<!-- Fim Modal -->

<!-- Modal Área -->
<div id="modal2" class="modal fade bd-example-modal-lg" role="dialog2" aria-labelledby=modal2>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="areaModal"></h5>
        </div>
        <div class="modal-body">

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">school</i>
                </span>
                <div class="form-group label-floating">
                    <span id="nivelModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">description</i>
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
<!-- Fim Modal Área -->

<!-- Modal Delete Nível -->
<div id="ModalDeleteNivel" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalDeleteNivel">
    <div class="modal-dialog" role="document3">
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
                    <input type="password" placeholder="Senha..." class="form-control" id="password3" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal -->

<!-- Modal Nível -->
<div id="modal1" class="modal fade bd-example-modal-lg" role="dialog2" aria-labelledby="nivelModal">
  <div class="modal-dialog" role="document2">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="nivelModal"></h5>
        </div>
        <div class="modal-body">

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">remove_circle</i>
                </span>
                <div class="form-group label-floating">
                    <span id="min_chModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">add_box</i>
                </span>
                <div class="form-group label-floating">
                    <span id="max_chModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">exposure_zero</i>
                </span>
                <div class="form-group label-floating">
                    <span id="palavrasModal"></span>
                </div>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">description</i>
                </span>
                <div class="form-group label-floating">
                    <span id="desModal"></span>
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

<!-- Modal -->
<div  id="modal0" class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="modal0">
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
<!-- Fim Modal -->

<!-- Modal Delete Escola -->
<div id="ModalDelete" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="ModalDelete">
    <div class="modal-dialog" role="document">
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
                    <input type="password" placeholder="Senha..." class="form-control" id="password4" name="password" required>
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

<script src="{{asset('js/main.js')}}"></script>
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
        var endereco = '';

        res.data.endereco ? endereco += res.data.endereco+", " : endereco += '';
        res.data.numero ? endereco += res.data.numero+", " : endereco += '';
        res.data.bairro ? endereco += res.data.bairro+", " : endereco += '';
        res.data.municipio ? endereco += res.data.municipio+", " : endereco += '';
        res.data.uf ? endereco += res.data.uf+", " : endereco += '';

        //altera o DOM
        $("#nome-curtoModal").html(res.dados.nome_curto);
        $("#nome-completoModal").html(res.dados.nome_completo);
        $("#emailModal").html(res.dados.email);
        $("#telefoneModal").html(res.dados.telefone);
        $("#enderecoModal").html(endereco);
        $("#cepModal").html(res.data.cep);

        //abre a modal
        $("#modal0").modal();

    });

})
</script>

<script type="application/javascript">
$('.modalNivel').click(function(){

    var idNivel = $(this).attr('id-nivel');

    //monta a url de consulta
    var urlConsulta = './nivel/dados-nivel/'+idNivel;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){

        console.log(res);

        //altera o DOM
        $("#nivelModal").html(res.dados.nivel);
        $("#min_chModal").html(res.dados.min_ch);
        $("#max_chModal").html(res.dados.max_ch);
        $("#desModal").html(res.dados.descricao);
        $("#palavrasModal").html(res.dados.palavras);

        //abre a modal
        $("#modal1").modal();

    });

})
</script>

<script type="application/javascript">
$('.modalEdicao').click(function(){

    var idEdicao = $(this).attr('id-edicao');

    //monta a url de consulta
    var urlConsulta = './edicao/dados-edicao/'+idEdicao;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){

        console.log(res);

        var pins = '';
        var phom = '';
        var pava = '';
        var pvol = '';
        var piah = '';
        var pcre = '';
        var teste = '';
        pins += "Período de Inscrição: ";
        res.dados.inscricao_abertura ? pins += res.dados.inscricao_abertura+" até " : pins += '';
        res.dados.inscricao_fechamento ? pins += res.dados.inscricao_fechamento+" " : pins += '';

        phom += "Período de Homologação: ";
        res.dados.homologacao_abertura ? phom += res.dados.homologacao_abertura+" até " : phom += '';
        res.dados.homologacao_fechamento ? phom += res.dados.homologacao_fechamento+" " : phom += '';

        pava += "Período de Avaliação: ";
        res.dados.avaliacao_abertura ? pava += res.dados.avaliacao_abertura+" até " : pava += '';
        res.dados.avaliacao_fechamento ? pava += res.dados.avaliacao_fechamento+" " : pava += '';

        pcre += "Período de Credenciamento: ";
        res.dados.credenciamento_abertura ? pcre += res.dados.credenciamento_abertura+" até " : pcre += '';
        res.dados.credenciamento_fechamento ? pcre += res.dados.credenciamento_fechamento+" " : pcre += '';

        pvol += "Período de Inscrição para Voluntário: ";
        res.dados.voluntario_abertura ? pvol += res.dados.voluntario_abertura+" até " : pvol += '';
        res.dados.voluntario_fechamento ? pvol += res.dados.voluntario_fechamento+" " : pvol += '';

        piah += "Período de Inscrição para Avaliador/Homologador: ";
        res.dados.comissao_abertura ? piah += res.dados.comissao_abertura+" até " : piah += '';
        res.dados.comissao_fechamento ? piah += res.dados.comissao_fechamento+" " : piah += '';

        for(var i=0; i<res.nivelEdicao.length; i++) {
        teste += "Nível ";
        res.nivel[i].nivel ? teste += res.nivel[i].nivel+":<br>" : teste
        teste += "      Áreas: ";
        for(var a=0; a<res.areaEdicao.length; a++) {
             if(res.nivel[i].id == res.area[a].nivel_id){
        		res.area[a].area_conhecimento ? teste += res.area[a].area_conhecimento+"<br>" : teste += '';
        	}
        }
        }
        //altera o DOM
        $("#anoModal").html(numeroEdicao(res.dados.ano));
        $("#pinsModal").html(pins);
        $("#phomModal").html(phom);
        $("#pcreModal").html(pcre);
        $("#pavaModal").html(pava);
        $("#pvolModal").html(pvol);
        $("#piahModal").html(piah);
         $("#testeModal").html(teste);

        //abre a modal
        $("#modal3").modal();

    });

})
</script>

<script type="application/javascript">
$('.modalArea').click(function(){

    //recupera o id da escola
    var idArea = $(this).attr('id-area');

    //monta a url de consulta
    var urlConsulta = './area/dados-area/'+idArea;
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){

        console.log(res);

        //altera o DOM
        $("#areaModal").html(res.dados.area_conhecimento);
        $("#nivelModal").html(res.data.nivel);
        $("#descricaoModal").html(res.dados.descricao);

        //abre a modal
        $("#modal2").modal();

    });

})
</script>

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
    $('tbody[id=4]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
}
function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('thead[id=3]').hide();
    $('thead[id=4]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
}
</script>
<script type="application/javascript">
$('.exclusao').click(function(){
    var idEscola = $(this).attr('id-escola');

    $("#ModalDelete").modal();

    $('.excluir').click(function(){
        var urlConsulta = './escola/exclui-escola/'+idEscola+'/'+$('#password4').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("Escola excluída com sucesso");
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

});
</script>
<script type="application/javascript">
$('.exclusaoNivel').click(function(){
    var idNivel= $(this).attr('id-nivel');

    $("#ModalDeleteNivel").modal();

    $('.excluir').click(function(){
        var urlConsulta = './nivel/exclui-nivel/'+idNivel+'/'+$('#password3').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("Nível excluído com sucesso");
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

});
</script>
<script type="application/javascript">
$('.exclusaoArea').click(function(){
    var idArea= $(this).attr('id-area');

    $("#ModalDeleteArea").modal();

    $('.excluir').click(function(){
        var urlConsulta = './area/exclui-area/'+idArea+'/'+$('#password').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("Área do conhecimento excluída com sucesso");
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

});
</script>
<script type="application/javascript">
$('.exclusaoEdicao').click(function(){
    var idEdicao= $(this).attr('id-edicao');

    $("#ModalDeleteEdicao").modal();

    $('.excluir').click(function(){
        var urlConsulta = './edicao/exclui-edicao/'+idEdicao+'/'+$('#password2').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("Edição excluída com sucesso");
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

});
</script>
@endsection

