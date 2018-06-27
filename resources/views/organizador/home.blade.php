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
                        <i class="material-icons">account_balance</i>
                        Escolas
                    </a>
                </li>
                <li>
                    <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
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

                    <tbody id="0">

                    @foreach($escolas as $i => $escola)

                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $escola->nome_curto }}</td>
                            <td></td>
                            <td>{{ $escola->email }}</td>
                            <td>{{ $escola->telefone }}</td>



                            <td class="td-actions text-right">

                                <a href="javascript:void(0);" class="modalEscola"  data-toggle="modal" data-target="#modal0" id-escola="{{ $escola->id }}"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                <a href="{{ route('escola', $escola->id) }}"><i class="material-icons">edit</i></a>

                                <a href="javascript:void(0);" class="exclusao" id-escola="{{ $escola->id }}"><i class="material-icons blue-icon">delete</i></a>
                            </td>
                        <tr>

                    @endforeach

                    </tbody>

                    <thead id="1">
                    <div id="1">
                        
                    </div>
                    
                    </thead>

                    <tbody id="1">
                        @foreach($projetos as $i => $projeto)

                        <div id="1" class="project">
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
                alert("Escola excluida");
                location.href = './administrador';
            }else{
                alert("Senha incorreta");
            }

        });
    });

});
</script>

@endsection
