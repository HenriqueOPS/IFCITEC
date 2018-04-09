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
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Alterar Edição</h2>
                    </div>
                </div>
                <form method="post" action="{{route('edicao')}}">

                    {{ csrf_field() }}

                    <input type="hidden" name="id_edicao" value="{{ $dados->id }}">

                    <!-- Período de Inscrição -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Período de Inscrição</h3>
                            <span>Durante esse período será possivel submeter projetos</span>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Início</label>
                                    <input type="datetime-local" class="form-control datepicker" name="inscricao_abertura" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->inscricao_abertura)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Fim</label>
                                    <input type="datetime-local" class="form-control datepicker" name="inscricao_fechamento" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->inscricao_fechamento)) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Período de Homologação -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Período de Homologação</h3>
                            <span>Durante esse período será possivel homologar os projetos recebidos</span>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Início</label>
                                    <input type="datetime-local" class="form-control datepicker" name="homologacao_abertura" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->homologacao_abertura)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Fim</label>
                                    <input type="datetime-local" class="form-control datepicker" name="homologacao_fechamento" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->homologacao_fechamento)) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Período de Avaliação -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Período de Avaliação</h3>
                            <span>Durante esse período será possivel avaliar os projetos homologados (Dia da Feira)</span>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Início</label>
                                    <input type="datetime-local" class="form-control datepicker" name="avaliacao_abertura" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->avaliacao_abertura)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Fim</label>
                                    <input type="datetime-local" class="form-control datepicker" name="avaliacao_fechamento" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->avaliacao_fechamento)) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Período de Credenciamento -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Período de Credenciamento</h3>
                            <span>Durante esse período será possivel realizar o credenciamento no evento (Dia da Feira)</span>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Início</label>
                                    <input type="datetime-local" class="form-control datepicker" name="credenciamento_abertura" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->credenciamento_abertura)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Fim</label>
                                    <input type="datetime-local" class="form-control datepicker" name="credenciamento_fechamento" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->credenciamento_fechamento)) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Período de Voluntário -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Período de Inscrição para Voluntário</h3>
                            <span>Durante esse período será possivel se inscrever para atuar como voluntário durante a feira</span>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Início</label>
                                    <input type="datetime-local" class="form-control datepicker" name="voluntario_abertura" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->voluntario_abertura)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Fim</label>
                                    <input type="datetime-local" class="form-control datepicker" name="voluntario_fechamento" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->voluntario_fechamento)) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Período de Inscrição para Avaliador/Homologador -->
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Período de Inscrição para Avaliador/Homologador</h3>
                            <span>Durante esse período será possivel se inscrever para atuar como voluntário durante a feira</span>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Início</label>
                                    <input type="datetime-local" class="form-control datepicker" name="comissao_abertura" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->comissao_abertura)) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-xs-9">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Fim</label>
                                    <input type="datetime-local" class="form-control datepicker" name="comissao_fechamento" value="{{ strftime('%Y-%m-%dT%H:%M:%S', strtotime($dados->comissao_fechamento)) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Níveis e Áreas da edição</h3>
                        </div>
                    @foreach($n as $nivel)
                    @foreach($nivelEdicao as $ni)
                    <div class="col-md-12 col-md-offset-1 col-xs-9">
                        @if($nivel->id == $ni->nivel_id && $dados->id == $ni->edicao_id)
                        <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{isset($nivel->id) ? $nivel->id : ''}}" checked>
                                    {{$nivel->nivel}}
                                </label>
                        </div>
                        @elseif($nivel->id != $ni->nivel_id && $dados->id == $ni->edicao_id)
                        <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$nivel->id}}" name='nivel_id[]'>
                                    {{$nivel->nivel}}
                                </label>
                        </div>
                        @endif
                        @foreach($areas as $area)
                        @foreach($areaEdicao as $ai)
                        @if($area->nivel_id == $nivel->id)
                        <div class="col-md-10 col-md-offset-2 col-xs-9">
                            @if($area->id == $ai->area_id && $dados->id == $ai->edicao_id)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{isset($dados->area_conhecimento) ? $dados->area_conhecimento : ''}}" checked>
                                    {{$area->area_conhecimento}}
                                </label>
                            </div>
                            @elseif($nivel->id != $ni->nivel_id && $dados->id == $ni->edicao_id)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{isset($dados->area_conhecimento) ? $dados->area_conhecimento : ''}}" checked>
                                    {{$area->area_conhecimento}}
                                </label>
                            </div>
                            @endif
                        </div>
                        @endif
                        @endforeach
                        @endforeach
                    </div>
                    @endforeach  
                    @endforeach
                    </div>

                    <!-- Campos Extras -->
                    <!--
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Campos Extras</h3>
                            <span>Estes campos irão aparecer no formulário que o autor irá cadastrar o projeto</span>
                        </div>


                    </div>
                    -->

                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Salvar Alterações</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection