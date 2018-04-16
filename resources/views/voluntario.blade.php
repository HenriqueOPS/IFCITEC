@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h2>Cadastro de Voluntário</h2>
                    </div>
                </div>
                <form method="POST" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info text-center">
                                <div class="container-fluid">
                                    <div class="alert-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                                    </button>
                                    <b>ATENÇÃO: </b>A inscrição não quer dizer que você já é um voluntário(a). Você receberá mais informações em breve!
                                </div>
                            </div> 
                            <div class="col-md-10 col-md-offset-1 text-center">
                            <a href="javascript:void(0);" class="confirma btn btn-success">
                                <i class="material-icons">directions_walk</i> Inscrever
                            </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal" class="modal fade bd-example-modal-lg" role="dialog" aria-labelledby="modal">
    <div class="modal-dialog" role="document1">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inscrição Voluntário</h5>
            </div>

            <div class="modal-body">
                <span>Para confirmar sua inscrição como voluntário, confirme sua senha.</span>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock_outline</i>
                    </span>
                    <input type="password" placeholder="Senha..." class="form-control" id="password" name="password" required>              
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary confirmado" data-dismiss="modal">Confirmar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="application/javascript">
$('.confirma').click(function(){

    $("#modal").modal();

    $('.confirmado').click(function(){
        var urlConsulta = './voluntario/cadastrar/'+$('#password').val();
        $.get(urlConsulta, function (res){
            if(res == 'true'){
                alert("Sua inscrição foi enviada com sucesso");
                location.href = './administrador';
            }else{
                alert("Senha incorreta");
            }

        });
    });

});
</script>
@endsection

