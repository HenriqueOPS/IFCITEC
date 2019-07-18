@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="main main-raised">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                            <h2>Editar Categoria</h2>
                        </div>
                    </div>
                    <form method="post" action="{{ route('editaCat') }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="id_categoria" value="{{ $dados->id }}">
                        <div class="row">

                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <div class="input-group{{ $errors->has('nivel_id') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nível</label>
                                        <select id="nivel-select" class="tp-select" name="nivel_id" id="nivel_id" value="{{isset($dados->nivel_id) ? $dados->nivel_id : ''}}" required>
                                            @foreach ($niveis as $nivel)

                                                @if($dados->nivel_id == $nivel->id)
                                                    <option value="{{$nivel->id}}" selected>{{$nivel->nivel}}</option>
                                                @else
                                                    <option value="{{$nivel->id}}">{{$nivel->nivel}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('nivel_id'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('nivel_id') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                    <div class="input-group{{ $errors->has('edicao_id') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="material-icons">text_fields</i>
                                    </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Edição</label>
                                            <select id="edicao-select" class="tp-select" name="edicao_id" id="edicao_id" value="{{isset($dados->edicao_id) ? $dados->edicao_id : ''}}" required>
                                                @foreach ($edicao as $ed)

                                                    @if($dados->nivel_id == $ed->id)
                                                        <option value="{{$ed->id}}" selected>{{\App\Edicao::numeroEdicao($ed->ano)}}</option>
                                                    @else
                                                        <option value="{{$ed->id}}">{{\App\Edicao::numeroEdicao($ed->ano)}}</option>
                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('edicao_id'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('edicao_id') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                    <div class="input-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                                        <span class="input-group-addon">
                                            <i class="material-icons">school</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nome Categoria</label>
                                            <input type="text" class="form-control" name="categoria_avaliacao" value="{{isset($dados->descricao) ? $dados->descricao: ''}}" required>
                                        </div>
                                        @if ($errors->has('descricao'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('descricao') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                    <div class="input-group{{ $errors->has('peso') ? ' has-error' : '' }}">
                                        <span class="input-group-addon">
                                            <i class="material-icons">school</i>
                                        </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Peso Categoria</label>
                                            <input type="text" class="form-control" name="peso" value="{{isset($dados->peso) ? $dados->peso: ''}}" required>
                                        </div>
                                        @if ($errors->has('peso'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('peso') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <button class="btn btn-primary">Salvar Alterações</button>

                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            var $tpSelect, $tpSelect;

            var oldTipo = $('.tp-select').attr("value");

            $edicaoSelect = $('.tp-select').selectize({
                placeholder: 'Escolha uma opção...',
                preload: true,
                onInitialize: function () {
                    this.setValue(oldTipo, false);
                    $('.selectize-input').addClass('form-control');
                },
            });


            $tpSelect= $tpSelect[0].selectize;
        });
    </script>
@endsection
