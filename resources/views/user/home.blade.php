@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3 text-center" >
                <a  href="{{route('projeto.create')}}" class="btn btn-success">
                    <i class="material-icons">add</i> Novo Projeto
                </a>

                <a href="{{route('comissaoAvaliadora')}}" class="btn btn-success">
                    <i class="material-icons">assignment</i> Quero Ser Avaliador/ Revisor
                </a>

                <a href="{{route('voluntario')}}" class="btn btn-success">
                    <i class="material-icons">directions_walk</i> Quero Ser Voluntário
                </a>
            </div>

            <div class="col-md-9 main main-raised">
                <div class="list-projects">
                    @if($funcoes->isEmpty())
                    <div class="text-center">
                        @if (!Auth::user()->temFuncao("Avaliador") && !Auth::user()->temFuncao("Revisor"))
                        <span class="function">Você não possui nenhum projeto</span><br>
                        @if(false)
                        <a href="{{route('projeto.create')}}" class="btn btn-success">
                            Novo Projeto
                        </a>
                        @endif
                        @else
                        <span class="function">Você não possui nenhum projeto para homologar/revisar</span><br>
                        @endif
                    </div>
                   
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
