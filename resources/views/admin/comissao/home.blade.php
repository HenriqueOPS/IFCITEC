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
            <div class="list-projects">
                    <table class="table" id="tab-comissao">
                        <div id="7">
                        <ul class="tab-comissao nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                            <li class="active">
                                <a id="avaliador" role="tab" data-toggle="tab">
                                    <i class="material-icons">assignment_ind</i>
                                    Avaliadores
                                </a>
                            </li>
                            <li>
                                <a id="homologador" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Homologadores
                                </a>
                            </li>
                            <li>
                                <a id="voluntario" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Voluntarios
                                </a>
                            </li>
                        </ul>

                        <thead id="7">

                        <tr>
                            <th>Nome</th>
                            <th>Instituição</th>
                            <th>Titulação</th>
                            <th>Status</th>
                            <th></th>
                        </tr>

                        </thead>

                    </div>

                    <tbody id="7">

                    @foreach($comissao as $c)

                        @if($c->funcao_id == 4)
                            <tr class="homologador">
                        @else
                            <tr class="avaliador">
                        @endif
                            <td>{{$c->nome}}</td>
                            <td>{{$c->instituicao}}</td>
                            <td>{{$c->titulacao}}</td>
                            <td>
                            @if ($c->homologado === true)
                            <span class="label label-success">Homologado</span>
                            @elseif ($c->homologado === false)
                            <span class="label label-warning">Não Homologado</span>
                            @else
                            <span class="label label-default">Cadastrado</span>
                            @endif
                            <td class="text-right">
                                <a href="{{route('homologarComissao',$c->id)}}"><i class="material-icons">group_add</i></a>
                                <a href="javascript:void(0);" class="exclusaoComissao" id-comissao="{{ $c->id }}" id-funcao="{{ $c->funcao_id }}"><i class="material-icons">delete</i></a>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                        </table>
                      
                        <table class="table" id="tab-voluntario">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Ano/Semestre</th>
                                        <th>Curso</th>
                                        <th>Turma</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($voluntarios as $voluntario)
                                        <tr>
                                            <td>{{$voluntario->nome}}</td>
                                            <td>{{$voluntario->ano}}</td>
                                            <td>{{$voluntario->curso}}</td>
                                            <td>{{$voluntario->turma}}</td>
                                            <td>
                                                @if ($voluntario->homologado === true)
                                                    <span class="label label-success">Homologado</span>
                                                @elseif ($voluntario->homologado === false)
                                                    <span class="label label-warning">Não Homologado</span>
                                                @else
                                                    <span class="label label-default">Cadastrado</span>
                                                @endif
                                            </td>
                                            <td>
                                            <a href="javascript:void(0);" class="HomologarVoluntario" data-id={{$voluntario->pessoa_id}}><i class="material-icons">group_add</i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete-->
<div id="ModalDelete" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="ModalDelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deletar Comissão</h5>
            </div>

            <div class="modal-body">
                <span>Para deletar o usuário da comissão avaliadora, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="passwordDelete" name="password" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary excluir" data-dismiss="modal">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- Fim Modal -->
<div id="ModalHomologar" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="ModalDelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Homologar Voluntario</h5>
            </div>

            <div class="modal-body">
                    <p><i class="material-icons">person</i> <strong>Nome:</strong> <span id="nome"></span></p>
                    <p><i class="material-icons">email</i> <strong>Email:</strong> <span id="email"></span></p>
                    <p><i class="material-icons">event</i> <strong>Ano/Semestre:</strong> <span id="ano"></span></p>
                    <p><i class="material-icons">school</i> <strong>Curso:</strong> <span id="curso"></span></p>
                    <p><i class="material-icons">school</i> <strong>Turma:</strong> <span id="turma"></span></p>
                    <p><i class="material-icons">phone</i> <strong>Telefone:</strong> <span id="telefone"></span></p>
         
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="NhomologarBtn">Não Homologar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="homologarBtn">Homologar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="{{asset('js/main.js')}}"></script>
<script type="application/javascript">


$(document).ready(function () {
    //comissao avaliadora
    $('tr.homologador').hide();
    $('#tab-voluntario').hide();
    $('.tab-comissao #homologador').click(function (e) {
        $('tr.avaliador').hide();
        $('tr.homologador').show();
        $('#tab-voluntario').hide();
        $('#tab-comissao').show();
    });

    $('.tab-comissao #avaliador').click(function (e) {
        $('tr.avaliador').show();
        $('tr.homologador').hide();
        $('#tab-voluntario').hide();
        $('#tab-comissao').show();
    });
    $('.tab-comissao #voluntario').click(function (e){
        $('#tab-comissao').hide();
        $('#tab-voluntario').show();
    });


});
$('.exclusaoComissao').click(function(){
    var idComissao= $(this).attr('id-comissao');
    var idFuncao= $(this).attr('id-funcao');

    $("#ModalDelete").modal();

    $('.excluir').click(function(){
        var urlConsulta = '.././comissao/excluir/'+idComissao+'/'+idFuncao+'/'+$('#passwordDelete').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                bootbox.alert("Usuário excluído da comissão avaliadora com sucesso");
                window.location.reload();
            }else if (res == 'false'){
                bootbox.alert("Senha incorreta");
            }
            else{
                bootbox.alert("Não foi possível excluir usuário da comissão avaliadora.");
            }

        });
    });

});
$('.HomologarVoluntario').click(function(){
    $("#ModalHomologar").modal();
            $.ajax({
                url: '/voluntario/info/' + $(this).data('id'),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Atualizar o conteúdo da div voluntarioInfo com as informações recebidas
                    $('#nome').text(data.nome);
                    $('#email').text(data.email);
                    $('#ano').text(data.ano);
                    $('#curso').text(data.curso);
                    $('#turma').text(data.turma);
                    $('#telefone').text(data.telefone);
                    $('#homologarBtn').attr('data-id', data.id);
                    $('#NhomologarBtn').attr('data-id', data.id);
                },
                error: function() {
                    console.log('Erro ao obter informações do voluntário.');
                }
            });
    
})
$('#homologarBtn').click(function(){
    homologação($(this).data('id'),true)
})
$('#NhomologarBtn').click(function(){
    homologação($(this).data('id'),false)
})
 function homologação(id,opção){
    $.ajax({
                url: '/voluntario/homologar/' + id,
                type: 'POST',
                dataType: 'json',
                data: { homologado: opção },
                success: function(data) {
                 alert(data.success)
                 location.reload();
                },
                error: function() {
                    alert('Erro ao obter informações do voluntário.');
                }
            });
 }
</script>

@endsection
