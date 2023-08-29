@extends('layouts.app')

@section('css')
<link href="{{ asset('css/selectize/selectize.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <div class="main main-raised">
                <div class="row">
                   
                </div>
              

                  

                    <input type="hidden" name="projeto" value="{{ $projeto->id }}">
                    <input type="hidden" name="rev1" value="{{ $revisao[0]->pessoa_id }}">
                    <input type="hidden" name="rev2" value="{{ $revisao[1]->pessoa_id }}">


                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-xs-offset-1 text-center">
                            <h2>Homologação</h2>
                        </div>
                    </div>
                   
                    <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                 <strong>Nota do Homologador 1: </strong>{{$revisao[0]->nota_final}}
                                </div>
                    </div>
                    <div class="row" id="selects">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                               
                                  
                                 <strong>Observação do Homologador 1: </strong>{{$revisao[0]->observacao}}
                               
                            </div>
                    </div>
                    <hr>
                  
                    <div class="row">
                                <div class="col-md-5 col-md-offset-1 col-xs-9 col-xs-offset-1">
                                <strong>Nota do Homologador 2: </strong> {{$revisao[1]->nota_final}}
                                </div>
                    </div>
                    <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-9 col-xs-offset-1">
                             
                                <strong>Observação do Homologador 2: </strong>  {{$revisao[1]->observacao}}
                                
                            </div>
                    </div>
                    <div class="row">
                            <div class="input-group{{ $errors->has('situacao') ? ' has-error' : '' }}">
                                    <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 text-center">
                                        <h3>Status do Projeto</h3>
                                    </div>
                                    <div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
                                       <strong>
                                    @foreach($situacoes as $situacao)
                                            @if($projeto->situacao_id == $situacao->id)                                        
                                                        {{$situacao->situacao}}
                                        @endif
                                        @endforeach
                                        </strong>
                                    </div>
                            </div>
                    </div>
                   
             
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection
