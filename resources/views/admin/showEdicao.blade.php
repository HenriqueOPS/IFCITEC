@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <center><h2>Edição V</h2></center>
                    </div>
                </div>
                <div class="row">
                    <div id="projeto-show">
                        <div class="col-md-7 col-md-offset-1">
                            <br>
                            <b><i class="material-icons">today</i> Ano:</b><br>  
                            <hr>
                            <b><i class="material-icons">access_time</i> Período da Feira:</b><br>  
                            <hr>
                            <b> <i class="material-icons">access_time</i> Período de Inscrição de Projetos:</b><br>
                            <hr>
                            <b> <i class="material-icons">access_time</i> Período de Inscrição de Homologadores:</b><br>
                            <hr>
                            <b> <i class="material-icons">access_time</i> Período de Inscrição de Avaliadores:</b><br>
                            <hr>
                            <b><i class="material-icons">access_time</i> Período de Homologação:</b><br>  
                            <hr>
                            <b><i class="material-icons">access_time</i> Período de Avaliação:</b><br>
                            <hr>
                            <b> <i class="material-icons">access_time</i> Período da Entrega do Relatório Final:</b><br>
                            


                        </div>
                        <div class="col-md-2 col-md-offset-2">
                            <a href="{{ route('editarEdicao') }}" id="novo-integrante" class="btn btn-round btn-primary">
                                 <i class="material-icons">edit</i>
                                Editar
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection