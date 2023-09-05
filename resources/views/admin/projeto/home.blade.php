@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>Painel administrativo</h2>
		</div>

        @include('partials.admin.navbar')
	</div>
</div>
<br><br>
<div class="container">

    <div class="row">

        <div class="col-md-12 main main-raised">

			@if($periodoAvaliacao)
				<a href="{{ route('dashboard') }}" target="_blank" class="btn btn-sm btn-primary">Dashboard de Avaliação</a>
			@endif

            <div class="list-projects">
                <h5><b id="geral">Número de projetos: <span id="nProjetos">{{ count($projetos) }}</span> </b></h5>
                <h5><b id="situacao">Número de projetos: <span>{{ count($projetos) }}</span> </b></h5>

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
                        <li>
                            <a id="6" class="tab-projetos" role="tab" data-toggle="tab">
                                <i class="material-icons">description</i>
                                Não Compareceu
                            </a>
                        </li>
                    </ul>
                </div>

                <div>

                    <a href="{{ route('homologar-projetos') }}" id="homologarTrabalhos" class="btn btn-sm btn-primary">Homologar Trabalhos</a>

                    @foreach($projetos as $projeto)

                        <div class="row project situacao-{{ $projeto->situacao_id }}">
                            <div class="col-md-10">
                                <div class="project-title">
                                    <span><a href="{{ route('projeto.show', ['projeto' => $projeto->id]) }}">{{ $projeto->titulo }}</a></span>
                                </div>
                                <div class="project-info">
                                    Integrantes:

									@foreach($projeto->pessoas as $pessoa)
										{{ $pessoa->nome }},
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
                                    <!-- COnfirmou Presença -->
                                        @if($projeto->statusPresenca())
                                        <span class="material-symbols-outlined" style="color: green;display: inline-flex; width: 20px; ">
                                            check_box
                                        </span>

                                        @else
                                        <span class="material-symbols-outlined" style="color: red;display: inline-flex; width: 20px; padding: 5px;">
                                        check_box_outline_blank
                                        </span>
                                        @endif
                                    @endif

                                    @if($projeto->getStatus() == "Não Homologado")
                                        @if($projeto->statusHomologacao() == 2)
                                            <span class="label label-success" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                        @elseif($projeto->statusHomologacao() == 1)
                                            <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;background-color: yellow;">&nbsp;</span>
                                       @else
                                       <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                            @endif
                                    @elseif($projeto->getStatus() == "Não Avaliado")
                                        @if($projeto->statusAvaliacao() == 2)
                                            <span class="label label-success" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                            @elseif($projeto->statusAvaliacao() == 1)
                                            <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;background-color: yellow;">&nbsp;</span>
                                            @else
                                            <span class="label label-danger" style="display: inline-flex; width: 20px; padding: 5px; margin-left: 5px;">&nbsp;</span>
                                        @endif
                                    @endif

                                </div>

                                <a class="dados-projeto" projeto-id="{{$projeto->id}}" href="#"><i class="material-icons blue-icon">remove_red_eye</i></a>

                                @if($projeto->getStatus() == "Não Avaliado" || $projeto->getStatus() == "Homologado")
                                    <a href="{{route('vinculaAvaliador',$projeto->id)}}"><i class="material-icons">assignment_ind</i></a>
                                @elseif ($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Cadastrado")
                                    <a href="{{route('vinculaRevisor',$projeto->id)}}"><i class="material-icons">assignment_ind</i></a>
                                @endif

                                @if($projeto->getStatus() == "Não Homologado" || $projeto->getStatus() == "Homologado")
                                     <a href="{{route('notaRevisao',$projeto->id)}}"><i class="material-icons blue-icon">looks_one</i></a>
                                @endif
                                
                               <a href="javascript:void(0);"class="naoCompareceu" data-id={{$projeto->id}} ><span class="material-icons">
                                                    delete
                                                    </span></a> 
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
                <h5 class="modal-title" id="nomeProjeto" style="font-weight: bold;"></h5>

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

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">school</i>
                    </span>
                    <div class="form-group label-floating">
                        <span class="modal-projeto escola"></span>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-symbols-outlined" style="margin-top: 10px;">location_on</i>
                    </span>
                    <div class="form-group label-floating">
                        <span class="modal-projeto municipio"></span>-<span class="modal-projeto uf"></span>
                    </div>
                </div>

                <div>
                    <h5><strong>Homologação</strong></h5>

                    <div id="homologadores"></div>
                </div>

                <div>
                    <h5><strong>Avaliação</strong></h5>

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

<!-- Modal Não Compareceu -->
<div id="ModalNaoCompareceu" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalNaoCompareceu">
    <div class="modal-dialog" role="document3">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Não Compareceu</h5>
            </div>

            <div class="modal-body">
                <span>Para confirmar que o projeto não compareceu, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="passwordNaoCompareceu" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary confirma" data-dismiss="modal">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Compareceu -->
<div id="ModalCompareceu" class="modal fade bd-example-modal-lg" role="dialog3" aria-labelledby="ModalCompareceu">
    <div class="modal-dialog" role="document2">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Compareceu</h5>
            </div>

            <div class="modal-body">
                <span>Para confirmar que o projeto compareceu, confirme sua senha e logo em seguida aperte no botão que corrsponde a situação do projeto.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="passwordCompareceu" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary avaliado" data-dismiss="modal">Avaliado</button>
                <button type="button" class="btn btn-primary naoavaliado" data-dismiss="modal">Não Avaliado</button>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
$('.dados-projeto').click(function() {

    //recupera o id do projeto
    var idProjeto = $(this).attr('projeto-id');

    //monta a url de consulta
    var urlConsulta = '../projeto/'+idProjeto+'/status';
    //faz a consulta via Ajax
    $.get(urlConsulta, function (res){

        $("#nomeProjeto").html(res.titulo);
		$("#projetoStatus").html('<span class="label label-default">' + res.situacao + '</span>');

        if (res.situacao == "Não Homologado" || res.situacao == "Não Avaliado") {
            $("#projetoStatus").html('<span class="label label-info">'+res.situacao+'</span>');
        } else if(res.situacao == "Homologado" || res.situacao == "Avaliado") {
            $("#projetoStatus").html('<span class="label label-success">' + res.situacao + '</span>');
        } else if(res.situacao == "Não Compareceu") {
            $("#projetoStatus").html('<span class="label label-danger">' + res.situacao + '</span>');
        }

        $(".modal-projeto.nivel").html(res.nivel);
        $(".modal-projeto.area").html(res.area);
        $(".modal-projeto.escola").html(res.escola_nome);
        $(".modal-projeto.municipio").html(res.escola_municipio);
        $(".modal-projeto.uf").html(res.escola_uf);

        var homologadores = res.homologacao;
        if(homologadores.length){
            $("#homologadores").html('');

            homologadores.forEach(function (homologador) {
                if (homologador.revisado) {
                    $("#homologadores").append('<span>' + homologador.nome + ' - <b>' + homologador.nota_final + '</b></span><br>');
                } else {
                    $("#homologadores").append('<span>' + homologador.nome + '</span><br>');
				}
            });
        }

        var avaliadores = res.avaliacao;
        if(avaliadores.length){
            $("#avaliadores").html('');

            avaliadores.forEach(function (avaliador) {
                if (avaliador.avaliado) {
                    $("#avaliadores").append('<span>' + avaliador.nome + ' - <b>' + avaliador.nota_final + '</b></span><br>');
                } else {
                    $("#avaliadores").append('<span>' + avaliador.nome + '</span><br>');
				}
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

		$('#homologarTrabalhos').hide();

        if (target.id==2)
            $('#homologarTrabalhos').show();

        if (target.id=='situacao') {
            $("#geral").hide();
            $("#situacao").show();
            showAll();
        } else {
            $("#situacao").hide();
            $("#geral").show();
            $("#nProjetos").html($('div.project.situacao-'+target.id).length);

            hideAll();

            $('div.project.situacao-'+target.id).show();
			$('div[id='+target.id+']').show();
        }

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

<script type="application/javascript">
$('.naoCompareceu').click(function(){
    var idProjeto= $(this).attr('data-id');

    $("#ModalNaoCompareceu").modal();
 
    $('.confirma').click(function(){
        var urlConsulta = '.././projeto/nao-compareceu/'+idProjeto+'/'+$('#passwordNaoCompareceu').val();
        console.log(idProjeto);
 
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("O projeto mudou de situação com sucesso!");
                window.location.reload();
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

});

$('.compareceu').click(function(){
    var idProjeto= $(this).attr('id-projeto');

    $("#ModalCompareceu").modal();

    $('.avaliado').click(function(){
        var urlConsulta = '.././projeto/compareceu/avaliado/'+idProjeto+'/'+$('#passwordCompareceu').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("O projeto mudou de situação com sucesso!");
                window.location.reload();
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

    $('.naoavaliado').click(function(){
        var urlConsulta = '.././projeto/compareceu/nao-avaliado/'+idProjeto+'/'+$('#passwordCompareceu').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("O projeto mudou de situação com sucesso!");
                window.location.reload();
            }else{
                bootbox.alert("Senha incorreta");
            }

        });
    });

});
</script>
@endsection

