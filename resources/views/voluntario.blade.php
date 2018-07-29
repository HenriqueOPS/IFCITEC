@extends('layouts.app')

@section('css')
<link href="{{ asset('css/layout.css') }}" rel="stylesheet">
<style>
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; top: 0; }
.se-pre-con {
    position: fixed;
    left: 520px;
    top: 350px;
    width: 3%;
    height: 3%;
    z-index: 1;
}
</style>
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
                <div class="panel-body">
                <form method="POST" action="{{route('cadastraVoluntario')}}">

                    {{ csrf_field() }}

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
                                    <b>ATENÇÃO: </b>Você receberá mais informações em breve!
                                </div>
                            </div>
                            <h4>Selecione a tarefa que você gostaria de realizar como voluntário da feira:</h4>
                                @foreach($tarefas as $tarefa)
                                    <div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
                                         @if($tarefa->pessoas()->count() == $tarefa->vagas)
                                            <div class="radio">
                                                <label>
                                                    <input type="radio"
                                                           class="tarefa"
                                                            name="tarefa"
                                                            value="{{$tarefa->id}}"
                                                            disabled>
                                                    {{$tarefa->tarefa}}
                                                </label>
                                            </div>
                                         @else
                                            <div class="radio">
                                                <label>
                                                    <input type="radio"
                                                           class="tarefa"
                                                            value="{{$tarefa->id}}"
                                                            name="tarefa"
                                                            >
                                                    {{$tarefa->tarefa}}
                                                </label>
                                            </div>
                                         @endif
                                    </div>
                                @endforeach  
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button href="javascript:void(0);" class="btn btn-primary">Inscrever</button>

                            </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection



