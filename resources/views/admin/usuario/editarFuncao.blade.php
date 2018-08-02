@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Administrar Usuários</h2>
        </div>
        <form method="post" action="{{ route('editaFuncaoUsuario', $usuario->id)}}">
        {{ csrf_field() }}


        <div class="col-md-12 main main-raised">

            <div class="list-projects">
                <table class="table">

                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuário</th>
                            <th>Funções</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-center">{{$usuario->id}}</td>
                            <td>{{$usuario->nome}}</td>

                            <td>
                            @foreach($funcoes as $funcao)
                            @if($funcao->funcao == 'Autor' || $funcao->funcao == 'Orientador' || $funcao->funcao == 'Coorientador')
                            @if($usuario->temFuncao($funcao->funcao))
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="{{$funcao->id}}" checked disabled>
                                    <span style="color: black">{{$funcao->funcao}}</span>
                                </label>
                            </div>
                            @else
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="{{$funcao->id}}" disabled>
                                    <span style="color: black">{{$funcao->funcao}}</span>
                                </label>
                            </div>
                            @endif
                            @else
                            @if($usuario->temFuncao($funcao->funcao, TRUE))
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="{{$funcao->id}}" checked>
                                    <span style="color: black">{{$funcao->funcao}}</span>
                                </label>
                            </div>
                            @else
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="funcao[]" value="{{$funcao->id}}">
                                    <span style="color: black">{{$funcao->funcao}}</span>
                                </label>
                            </div>
                            @endif
                            @endif
                            @endforeach
                            </td>
                        <tr>
                    </tbody>
                </table>
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
@endsection
