@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">

    <div class="row">

        <div class="col-md-12 main main-raised">

            <div class="col-md-12 text-center">
                <h2>Comissão Organizadora</h2>
                <h3>Projetos</h3>
            </div>

            <div class="list-projects">
                <h5><b id="geral">Número de projetos: <span id="nProjetos">{{$numeroProjetos}}</span> </b></h5>
                <h5><b id="situacao">Número de projetos: <span>{{$numeroProjetos}}</span> </b></h5>

                <div>
                    <ul class="nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                        <li class="active">
                            <a id="situacao" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">assignment_ind</i>
                                Todos
                            </a>
                        </li>
                        <li>
                            <a id="1" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">description</i>
                                Cadastrados
                            </a>
                        </li>
                        <li>
                            <a id="2" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">description</i>
                                Não Homologados
                            </a>
                        </li>
                        <li>
                            <a id="3" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">assignment_ind</i>
                                Homologados
                            </a>
                        </li>
                        <li>
                            <a id="4" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">description</i>
                                Não Avaliados
                            </a>
                        </li>
                        <li>
                            <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">description</i>
                                Avaliados
                            </a>
                        </li>
                    </ul>
                </div>

                <div>

                    <a href="{{route('homologar-projetos')}}" id="homologarTrabalhos" class="btn btn-sm btn-primary">Homologar Trabalhos</a>

                    @foreach($projetos as $projeto)

                        <div class="row project situacao-{{$projeto->situacao_id}}">
                            <div class="col-md-10">
                                <div class="project-title">
                                    <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                                </div>
                                <div class="project-info">
                                    Integrantes:
                                    @foreach ($autores as $autor)
                                        @if($autor->projeto_id == $projeto->id)
                                            {{$autor->nome}},
                                        @endif
                                    @endforeach

                                    @foreach ($orientadores as $orientador)
                                        @if($orientador->projeto_id == $projeto->id)
                                            {{$orientador->nome}},
                                        @endif
                                    @endforeach

                                    @foreach($coorientadores as $coorientador)
                                        @if($coorientador->projeto_id == $projeto->id)
                                            {{$coorientador->nome}},
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-2 actions text-center">
                                <div class="status">
                                    @if($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Não Avaliado")
                                        <span class="label label-info">{{$projeto->getStatus()}}</span>
                                    @elseif ($projeto->getStatus() == "Homologado" || $projeto->getStatus() == "Avaliado")
                                        <span class="label label-success">{{$projeto->getStatus()}}</span>
                                    @elseif ($projeto->getStatus() == "Não Compareceu")
                                        <span class="label label-danger">{{$projeto->getStatus()}}</span>
                                    @else
                                        <span class="label label-default">{{$projeto->getStatus()}}</span>
                                    @endif

                                    @if($projeto->getStatus() == "Homologado")
                                        @if($projeto->statusPresenca())
                                            <span class="label label-warning" style="display: inline-flex; width: 20px; padding: 5px;">&nbsp;</span>
                                        @else
                                            <span class="label label-default" style="display: inline-flex; width: 20px; padding: 5px;">&nbsp;</span>
                                        @endif
                                    @endif

                                    @if($projeto->getStatus() == "Não Homologado")
                                        @if($projeto->statusHomologacao())
                                            <span class="label label-success" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                        @else
                                            <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                        @endif
                                    @elseif($projeto->getStatus() == "Não Avaliado")
                                        @if($projeto->statusAvaliacao())
                                            <span class="label label-success" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                        @else
                                            <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                        @endif
                                    @endif

                                </div>

                                <a class="dados-projeto" projeto-id="{{$projeto->id}}"><i class="material-icons blue-icon">pan_tool</i></a>

                                @if($projeto->getStatus() == "Não Avaliado" || $projeto->getStatus() == "Homologado")
                                    <a href="{{route('vinculaAvaliador',$projeto->id)}}"><i class="material-icons">assignment_ind</i></a>
                                @elseif ($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Cadastrado")
                                    <a href="{{route('vinculaRevisor',$projeto->id)}}"><i class="material-icons">assignment_ind</i></a>
                                @endif

                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('partials')

<!-- Modal Projeto -->
<div id="ModalProjeto" class="modal fade bd-example-modal-lg" role="dialog2" aria-labelledby="ModalProjeto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nomeProjeto"></h5>

                <div id="projetoStatus" style="margin-top: 10px;"></div>
            </div>

            <div class="modal-body">

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">school</i>
                    </span>
                    <div class="form-group label-floating">
                        <span class="modal-projeto nivel"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">school</i>
                    </span>
                    <div class="form-group label-floating">
                        <span class="modal-projeto area"></span>
                    </div>
                </div>

                <div>
                    <h5>Homologação</h5>

                    <div id="homologadores"></div>
                </div>

                <div>
                    <h5>Avaliação</h5>

                    <div id="avaliadores"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal Área -->


<script type="application/javascript">
$('.dados-projeto').click(function(){

    //recupera o id do projeto
    var idProjeto = $(this).attr('projeto-id');

    //monta a url de consulta
    var urlConsulta = '../projeto/'+idProjeto+'/status';
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){

        console.log(res);

        $("#nomeProjeto").html(res.titulo);

        $("#projetoStatus").html('');

        if(res.situacao == "Não Homologado" || res.situacao == "Não Avaliado"){
            $("#projetoStatus").html('<span class="label label-info">'+res.situacao+'</span>');
        }else if(res.situacao == "Homologado" || res.situacao == "Avaliado"){
            $("#projetoStatus").html('<span class="label label-success">' + res.situacao + '</span>');
        }else if(res.situacao == "Não Compareceu"){
            $("#projetoStatus").html('<span class="label label-danger">' + res.situacao + '</span>');
        }else{
            $("#projetoStatus").html('<span class="label label-default">' + res.situacao + '</span>');
        }

        $(".modal-projeto.nivel").html(res.nivel);
        $(".modal-projeto.area").html(res.area);

        var homologadores = res.homologacao;
        if(homologadores.length){
            $("#homologadores").html('');

            homologadores.forEach(function (homologador) {
                if(homologador.revisado)
                    $("#homologadores").append('<span>'+homologador.nome+' => '+homologador.nota_final+'</span><br>');
                else
                    $("#homologadores").append('<span>'+homologador.nome+'</span><br>');
            });
        }

        var avaliadores = res.avaliacao;
        if(avaliadores.length){
            $("#avaliadores").html('');

            avaliadores.forEach(function (avaliador) {
                if(avaliador.revisado)
                    $("#avaliadores").append('<span>'+avaliador.nome+' => '+avaliador.nota_final+'</span><br>');
                else
                    $("#avaliadores").append('<span>'+avaliador.nome+'</span><br>');
            });
        }

        //abre a modal
        $("#ModalProjeto").modal();

    });

})
</script>

@endsection

@section('js')
<script src="{{asset('js/main.js')}}"></script>
<script type="application/javascript">
$(document).ready(function () {
    $('#homologarTrabalhos').hide();
    $("#situacao").hide();

    $('.tab-projetos').click(function (e) {
        var target = $(this)[0];

        console.log('div.project.situacao-'+target.id);

        if(target.id==2){
            $('#homologarTrabalhos').show();
        }else{
            $('#homologarTrabalhos').hide();
        }

        if(target.id=='situacao'){
            $("#geral").hide();
            $("#situacao").show();
            showAll();
        }else{
            $("#situacao").hide();
            $("#geral").show();
            $("#nProjetos").html($('div.project.situacao-'+target.id).length);
            hideAll();
            $('div.project.situacao-'+target.id).show();
            $('div[id='+target.id+']').show();
        }

        
        console.log(target.id);


    });

});

function hideAll(){
    $('div.project.situacao-1').hide();
    $('div.project.situacao-2').hide();
    $('div.project.situacao-3').hide();
    $('div.project.situacao-4').hide();
    $('div.project.situacao-5').hide();
    $('div.project.situacao-6').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();

}

function showAll(){
    $('div.project.situacao-1').show();
    $('div.project.situacao-2').show();
    $('div.project.situacao-3').show();
    $('div.project.situacao-4').show();
    $('div.project.situacao-5').show();
    $('div.project.situacao-6').show();
}

</script>

@endsection