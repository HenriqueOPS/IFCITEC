@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                        <h2>Editar Brinde</h2>
                    </div>
                </div>
                <form method="post" action="{{ route('editaBrinde') }}">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="id_brinde" value="{{ $brinde->id }}" required>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">description</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Descrição</label>
                                    <textarea class="form-control" name="descricao" required>{{ $brinde->descricao }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">straighten</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Tamanho</label>
                                    <input type="text" class="form-control" name="tamanho" value="{{ $brinde->tamanho }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

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

@section('css')
<style>
    /* Estilos CSS personalizados */
</style>
@endsection

@section('js')
<script>
    // Código JavaScript personalizado, se necessário
</script>
@endsection
