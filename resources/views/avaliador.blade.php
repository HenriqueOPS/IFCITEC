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
                    <div class="col-md-10 col-md-offset-1">
                        <h2>Cadastro de Comissão Avaliadora</h2>
                    </div>
                </div>
                <form method="POST" action="{{route('register')}}">
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
                                    <b>ATENÇÃO: </b>É de total resposabilidade do usuário a veracidade dos dados aqui informados
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 col-md-offset-1">

                            {{ csrf_field() }}
                            <input type="hidden" name="inscricao" value="avaliacao">

                            <div class="input-group{{ $errors->has('titulacao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">bookmark</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Titulacao</label>
                                    <input type="text" class="form-control" name="titulacao" value="{{old('titulacao')}}" >
                                </div>
                                @if ($errors->has('titulacao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('titulacao') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('lattes') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">insert_link</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Link Lattes</label>
                                    <input type="url" class="form-control" name="lattes" value="{{old('lattes')}}" required>
                                </div>
                                @if ($errors->has('lattes'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lattes') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('profissao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">assignment_ind</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Profissao</label>
                                    <input type="text" class="form-control" name="profissao" value="{{old('profissao')}}" required>
                                </div>
                                @if ($errors->has('profissao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('profissao') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('instituicao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Instituicao</label>
                                    <input type="text" class="form-control" name="instituicao" value="{{old('instituicao')}}" required>
                                </div>
                                @if ($errors->has('instituicao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('instituicao') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="input-group{{ $errors->has('area') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Área do Conhecimento</label>
                                    <select id="area-select" name="area" value="{{old('area')}}" required>
                                        <option></option>
                                        @foreach ($areas as $area)
                                            <option value="{{$area->id}}">{{$area->area_conhecimento}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('area'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('area') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="input-group{{ $errors->has('dt_nascimento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">today</i>
                                </span>
                                <div class="form-group ">
                                    <label class="control-label">Data Nascimento</label>
                                    <input type="text" class="form-control datepicker" name="dt_nascimento" value="{{ old('dt_nascimento') }}"  required>
                                </div>
                                @if ($errors->has('dt_nascimento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dt_nascimento') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <h2>Endereço</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">

                            <div class="input-group{{ $errors->has('rua') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Rua</label>
                                    <input type="text" class="form-control" name="rua" value="{{ old('rua') }}" required>
                                </div>
                                @if ($errors->has('rua'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rua') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero</label>
                                    <input type="number" class="form-control" name="numero" value="{{ old('numero') }}" required>
                                </div>
                                @if ($errors->has('numero'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('numero') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Bairro</label>
                                    <input type="text" class="form-control" name="bairro" value="{{ old('bairro') }}" required>
                                </div>
                                @if ($errors->has('bairro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bairro') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Cidade</label>
                                    <input type="text" class="form-control" name="cidade" value="{{ old('cidade') }}" required>
                                </div>
                                @if ($errors->has('cidade'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cidade') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('estado') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">UF</label>
                                    <input type="text" class="form-control" name="estado" value="{{ old('estado') }}"  maxlength="2" required>
                                </div>
                                @if ($errors->has('estado'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('estado') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('cep') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">CEP (Apenas Números)</label>
                                    <input type="number" class="form-control" name="cep" value="{{ old('cep') }}" required>
                                </div>
                                @if ($errors->has('cep'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cep') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="input-group{{ $errors->has('complemento') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">place</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Complemento</label>
                                    <input type="text" class="form-control" name="complemento" value="{{ old('complemento') }}">
                                </div>
                                @if ($errors->has('complemento'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('complemento') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <p>Você pode escolher varios:</p>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="3">
                                    <span style="color: black">Quero ser Avaliador</span>
                                </label>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="4">
                                    <span style="color: black">Quero ser Homologador</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <button class="btn btn-primary">Inscrever</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{asset('js/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('js/datepicker/locales/bootstrap-datepicker.pt-BR.js')}}"></script>
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        templates: {
            leftArrow: '&lsaquo;',
            rightArrow: '&rsaquo;'
        },
    });
    $(document).ready(function () {
        var oldArea = $('#area-select').attr("value");

        $nivelSelect = $('#area-select').selectize({
            placeholder: 'Escolha a Área...',
            preload: true,
            onInitialize: function () {
                this.setValue(oldArea, false);
                $('.selectize-input').addClass('form-control');
            },
        });
    });
</script>
@endsection