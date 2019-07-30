@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 text-center">
            <h2>Administrar Usuários</h2>
        </div>

         <div class="row hide" id="loadCadastro">
                    <div class="loader loader--style2" title="1">
                        <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="80px" height="80px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                          <path fill="#000" d="M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z">
                              <animateTransform attributeType="xml"
                                                attributeName="transform"
                                                type="rotate"
                                                from="0 25 25"
                                                to="360 25 25"
                                                dur="0.6s"
                                                repeatCount="indefinite"/>
                          </path>
                          </svg>
                    </div>

        </div>

        <form method="post" id="cadastraVoluntario" action="{{ route('editaFuncaoUsuario', $usuario->id)}}">
        {{ csrf_field() }}


        <div class="col-md-12 col-xs-12 main main-raised">

            <div class="list-projects">
                <table class="table">

                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Usuário</th>
                            <th>Funções</th>
                            @if($usuario->temFuncao('Voluntário'))
                            <th>Tarefa</th>
                            @endif
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

                            @if($funcao->funcao == 'Homologador' || $funcao->funcao == 'Avaliador')
                            @if($usuario->temFuncao($funcao->funcao, TRUE))
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
                            @endif
                            @endforeach
                            </td>
                            @if($usuario->temFuncao('Voluntário'))
                            <td>
                                @foreach($tarefas as $tarefa)

                                    <div class="col-md-10 col-md-offset-2 col-xs-9 col-xs-offset-1">
                                            @if($usuario->tarefas->first() != null)
                                                @if($usuario->tarefas->first()->id == $tarefa->id)
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio"
                                                               class="tarefa"
                                                                name="tarefa"
                                                                value="{{$tarefa->id}}"
                                                                checked>
                                                        {{$tarefa->tarefa}}
                                                    </label>
                                                </div>
                                                @else
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio"
                                                               class="tarefa"
                                                                name="tarefa"
                                                                value="{{$tarefa->id}}"
                                                                >
                                                        {{$tarefa->tarefa}}
                                                    </label>
                                                </div>
                                                @endif
                                            @else
                                            <div class="radio">
                                                    <label>
                                                        <input type="radio"
                                                               class="tarefa"
                                                                name="tarefa"
                                                                value="{{$tarefa->id}}"
                                                                >
                                                        {{$tarefa->tarefa}}
                                                    </label>
                                            </div>
                                            @endif
                                    </div>
                                @endforeach
                            </td>
                        @endif
                        </tr>
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

@section('js')
<script type="text/javascript">
$(document).ready(function () {

    let frm = $('#cadastraVoluntario');

    frm.submit(function(event) {

        $('#loadCadastro').removeClass('hide');

    });
});
</script>
@endsection
