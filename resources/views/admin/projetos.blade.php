@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
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
                            <i class="material-icons">adjust</i>
                            Edições
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="1" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">account_balance</i>
                            Escolas
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="2" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">school</i>
                            Níveis
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="3" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">brightness_auto</i>
                            Áreas
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="4" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">title</i>
                            Tarefas (Voluntários)
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="5" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">person</i>
                            Usuários
                        </a>
                    </li>
                    <li class="active">
                        <a href="dashboard" id="6" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">list_alt</i>
                            Listar Projetos
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="7" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">list_alt</i>
                            Comissão Avaliadora
                        </a>
                    </li>
                    <li>
                        <a href="dashboard" id="8" class="tab" role="tab" data-toggle="tab">
                            <i class="material-icons">description</i>
                            Relatórios
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="row">

            <div class="col-md-12 main main-raised">
                <div class="list-projects">

                    <thead id="6">
                        <div id="6">
                            <h5><b>Número de projetos: {{$numeroProjetos}} </b></h5>
                        </div>
                    </thead>

                    <div>
                        <ul class="nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                            <li class="active">
                                <a id="situacao" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">assignment_ind</i>
                                    Todos
                                </a>
                            </li>
                            <li>
                                <a id="1" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Cadastrados
                                </a>
                            </li>
                            <li>
                                <a id="2" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Não Homologados
                                </a>
                            </li>
                            <li>
                                <a id="3" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">assignment_ind</i>
                                    Homologados
                                </a>
                            </li>
                            <li>
                                <a id="4" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Não Avaliados
                                </a>
                            </li>
                            <li>
                                <a id="5" class="tab-projetos" role="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Avaliados
                                </a>
                            </li>
                        </ul>

                        <tbody id="6">
                        @foreach($projetos as $projeto)

                            <div id="6" class="project situacao-{{$projeto->situacao_id}}">
                                <div class="project-title">
                                    <span><a href="{{route('projeto.show', ['projeto' => $projeto->id])}}">{{$projeto->titulo}}</a></span>
                                </div>
                                <div class="project-info">
                                    Integrantes:
                                    @foreach ($autores as $autor)
                                        @if($autor->projeto_id == $projeto->id)
                                            {{$autor->nome}},
                                        @endif
                                    @endforeach

                                    @foreach ($orientadores as $orientador)
                                        @if($orientador->projeto_id == $projeto->id)
                                            {{$orientador->nome}},
                                        @endif
                                    @endforeach

                                    @foreach($coorientadores as $coorientador)
                                        @if($coorientador->projeto_id == $projeto->id)
                                            {{$coorientador->nome}},
                                        @endif
                                    @endforeach
                                </div>



                                <div class="td-actions text-right">
                                    <a href=""><i class="material-icons blue-icon">remove_red_eye</i></a>
                                    <a href=""><i class="material-icons">assignment_ind</i></a>
                                    <a href="" class="setAvaliado"><i class="material-icons blue-icon">check_circle</i></a>
                                    <a href="" class="setNaoCompareceu"><i class="material-icons">help</i></a>
                                </div>
                            </div>

                        @endforeach
                        </tbody>



                    </table>

                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script src="{{asset('js/main.js')}}"></script>
<script type="application/javascript">
$(document).ready(function () {

    $('.tab-projetos').click(function (e) {
        var target = $(this)[0];

        console.log('div.project.situacao-'+target.id);
        if(target.id=='situacao'){
            showAll();
        }else{
            hideAll();

            $('div.project.situacao-'+target.id).show();
        }
    });
});

function hideAll(){
    $('div.project.situacao-1').hide();
    $('div.project.situacao-2').hide();
    $('div.project.situacao-3').hide();
    $('div.project.situacao-4').hide();
    $('div.project.situacao-5').hide();
    $('div.project.situacao-6').hide();
}

function showAll(){
    $('div.project.situacao-1').show();
    $('div.project.situacao-2').show();
    $('div.project.situacao-3').show();
    $('div.project.situacao-4').show();
    $('div.project.situacao-5').show();
    $('div.project.situacao-6').show();
}

</script>

@endsection

