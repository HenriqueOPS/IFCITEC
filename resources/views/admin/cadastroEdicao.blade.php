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
                        <h2>Cadastro de Edição</h2>
                    </div>
                </div>
                <form method="post" action="{{route('cadastraEdicao')}}">

                    {{ csrf_field() }}

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
                                    <input type="datetime-local" class="form-control datepicker" name="inscricao_abertura" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="inscricao_fechamento" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="homologacao_abertura" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="homologacao_fechamento"  required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="avaliacao_abertura" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="avaliacao_fechamento" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="credenciamento_abertura" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="credenciamento_fechamento" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="voluntario_abertura" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="voluntario_fechamento" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="comissao_abertura" required>
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
                                    <input type="datetime-local" class="form-control datepicker" name="comissao_fechamento" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h3>Níveis e Áreas da edição</h3>
                        </div>
                    @foreach($niveis as $nivel)
                    <div class="col-md-12 col-md-offset-1 col-xs-9">
                        <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$nivel->id}}" name='nivel_id[]' checked>
                                    {{$nivel->nivel}}
                                </label>
                        </div>
                        @foreach($areas as $area)
                        @if($area->nivel_id == $nivel->id)
                        <div class="col-md-10 col-md-offset-2 col-xs-9">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="{{$area->id}}" name='area_id[]' checked>
                                    {{$area->area_conhecimento}}
                                </label>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
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
                            <button class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
  

</script>

@endsection