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
                        <h2>Cadastro de Nível</h2>
                    </div>
                </div>
                <form name="f1" method="post" action="{{route('cadastroNivel')}}">

                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Nome do Nível</label>
                                    <input type="text" class="form-control" name="nivel" required>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Caracteres mínimos para resumo</label>
                                    <input type="number" class="form-control" name="min_ch" required>
                                </div>
                            </div>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">text_fields</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Caracteres máximos para resumo</label>
                                    <input type="number" class="form-control" name="max_ch" min="min_ch" required>
                                </div>
                            </div>
                
                            <div class="form-group">
                                <div class="form-group label-floating">
                                    <i class="material-icons">description</i>
                                    <label for="exampleFormControlTextarea1">Descrição</label>
                                    <textarea class="form-control" rows="3" name="descricao" required></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
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

