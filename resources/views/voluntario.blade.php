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
                            <h3>Confirma sua inscrição como voluntário?</h3>
                            <a class="btn btn-success">
                                <i class="material-icons">directions_walk</i> Sim
                            </a>
                            <a class="btn btn-success">
                                <i class="material-icons">arrow_back</i> Voltar
                            </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

