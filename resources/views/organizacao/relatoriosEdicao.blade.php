@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            <div id="page" class="col-md-12">
            <ul class="nav nav-pills nav-pills-primary"  role="tablist">
                    <li>
                        <a href="dashboard" id="0" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">account_balance</i>
                            Escolas
                        </a>
                    </li>
                    <li>
                        <a href="{{route('organizacao.projetos')}}">
                            <i class="material-icons">list_alt</i>
                            Listar Projetos
                        </a>
                    </li>
                    <li>
                        <a href="{{route('organizacao.presenca')}}">
                            <i class="material-icons">account_circle</i>
                            Presença
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{route('organizacao.relatoriosEdicao')}}">
                            <i class="material-icons">description</i>
                            Relatórios
                        </a>
                    </li>
                    <li>
                        <a href="{{route('organizacao.usuarios')}}">
                            <i class="material-icons">person</i>
                            Usuários
                        </a>
                    </li>
            </ul>
        </div>
    </div>
</div>
<br><br>
<div class="container">
 <form method="post" action="{{route('organizacao.escolheEdicao')}}">
                    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 main main-raised">
           <div class="input-group{{ $errors->has('edicao') ? ' has-error' : '' }}">
                                <span class="input-group-addon">
                                    <i class="material-icons">school</i>
                                </span>
                                <div class="form-group">
                                    <label class="control-label">Edição</label>
                                    <select id="edicao-select" name="edicao" value="{{old('edicao') ? old('edicao'): ''}}" required>
                                        <option></option>
                                        @foreach ($edicoes as $edicao)
                                            @if ($edicao->id == old('edicao'))
                                                <option selected="selected" value="{{$edicao->id}}">{{\App\Edicao::numeroEdicao($edicao->ano)}} IFCITEC</option>
                                            @else
                                                <option value="{{$edicao->id}}">{{\App\Edicao::numeroEdicao($edicao->ano)}} IFCITEC</option>

                                            @endif
                                        @endforeach
                                    </select>

                                    @if ($errors->has('edicao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('edicao') }}</strong>
                                    </span>
                                    @endif
                                </div>
            </div>
            <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <button class="btn btn-primary">Enviar</button>
                    </div>
            </div>
        </div>
    </div>
    </form>
</div>
@endsection

@section('js')

<script src="{{asset('js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('js/selectize.min.js')}}"></script>
<script type="application/javascript">
$(document).ready(function () {

    var oldEdicao = $('#edicao-select').attr("value");
    $('#edicao-select').selectize({
        placeholder: 'Escolha uma edição...',
        onInitialize: function () {
            this.setValue(oldEdicao, true);
            //$('.selectize-control').addClass('form-group');
            $('.selectize-input').addClass('form-control');
        },
    });
});
</script>

@endsection
