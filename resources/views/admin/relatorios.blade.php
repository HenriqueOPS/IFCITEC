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
                    <a href="{{route('administrador')}}">
                        <i class="material-icons">adjust</i>
                        Edições
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.escolas')}}">
                        <i class="material-icons">account_balance</i>
                        Escolas
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.niveis')}}">
                        <i class="material-icons">school</i>
                        Níveis
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.areas')}}">
                        <i class="material-icons">brightness_auto</i>
                        Áreas
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.tarefas')}}">
                        <i class="material-icons">title</i>
                        Tarefas (Voluntários)
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.usuarios')}}">
                        <i class="material-icons">person</i>
                        Usuários
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.projetos')}}">
                        <i class="material-icons">list_alt</i>
                        Listar Projetos
                    </a>
                </li>
                <li>
                    <a href="{{route('administrador.comissao')}}">
                        <i class="material-icons">list_alt</i>
                        Comissão Avaliadora
                    </a>
                </li>
                <li class="active">
                    <a href="{{route('administrador.relatorios')}}">
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
                    <table class="table">
                    <ul class="tab-comissao nav nav-pills nav-pills-primary" role="tablist" style="margin-bottom: 30px">
                            <li class="active">
                                <a id="0" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Avaliação
                                </a>
                            </li>
                            <li>
                                <a id="1" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">assignment_ind</i>
                                    Gerais
                                </a>
                            </li>
                            <li>
                                <a id="2" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Homologação
                                </a>
                            </li>
                            <li>
                                <a id="3" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Premiação
                                </a>
                            </li>
                            <li>
                                <a id="4" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Projetos
                                </a>
                            </li>
                            <li>
                                <a id="5" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Voluntários
                                </a>
                            </li>
                            <li>
                                <a id="6" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Usuários
                                </a>
                            </li>
                    </ul>

                    <thead id="0">
                    <div id="0">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Relatórios</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </div>
                    </thead>

                    <tbody id="0">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Avaliadores</td>
                            <td class="text-right">
                                <a href="{{route('csv', 1)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Avaliadores Por Área do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('avaliadoresArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Avaliadores Por Projeto</td>
                            <td class="text-right">
                                <a href="{{route('avaliadoresProjeto')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                    </tbody>

                    <tbody id="1">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Áreas do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('relatorioArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Edições</td>
                            <td class="text-right">
                                <a href="{{route('relatorioEdicao')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Escolas</td>
                            <td class="text-right">
                                <a href="{{route('relatorioEscola')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Relatório de Níveis</td>
                            <td class="text-right">
                                <a href="{{route('relatorioNivel')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Relatório de Projetos Que Comparecerão na {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</td>
                            <td class="text-right">
                                <a href="{{route('relatorioProjetosConfirma')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Relatório de Projetos Que Compareceram na {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</td>
                            <td class="text-right">
                                <a href="{{route('projetosCompareceram')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                    </tbody>

                    <tbody id="2">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Homologadores</td>
                            <td class="text-right">
                                <a href="{{route('csv', 2)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Homologadores Por Área do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('homologadoresArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Homologadores Por Projeto</td>
                            <td class="text-right">
                                <a href="{{route('homologadoresProjeto')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Relatório de Projetos Classificados Para a {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} Edição (Por Área do Conhecimento)</td>
                            <td class="text-right">
                                <a href="{{route('projetosClassificados')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Relatório de Projetos Classificados Para a {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} Edição (Por Nível)</td>
                            <td class="text-right">
                                <a href="{{route('projetosClassificadosNivel')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Relatório de Projetos Classificados Para a {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} Edição (Sem Notas)</td>
                            <td class="text-right">
                                <a href="{{route('projetosClassificadosSemNota')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Relatório de Projetos Não Homologados Para a {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} Edição (Por Nível)</td>
                            <td class="text-right">
                                <a href="{{route('projetosNaoHomologadosNivel')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                    </tbody>

                    <tbody id="3">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Classificação Geral dos Projetos</td>
                            <td class="text-right">
                                <a href="{{route('classificacaoGeral')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Classificação Geral dos Projetos Por Área do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('classificacaoProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Premiação dos Projetos</td>
                            <td class="text-right">
                                <a href="{{route('premiacaoProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                    </tbody>

                    <tbody id="4">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Projetos</td>
                            <td class="text-right">
                                <a href="{{route('relatorioProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Projetos E Seus Status</td>
                            <td class="text-right">
                                <a href="{{route('statusProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Projetos Que Comparecerão na {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</td>
                            <td class="text-right">
                                <a href="{{route('relatorioProjetosConfirma')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Relatório de Projetos Que Compareceram na {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} IFCITEC</td>
                            <td class="text-right">
                                <a href="{{route('projetosCompareceram')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="5">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Voluntários</td>
                            <td class="text-right">
                                <a href="{{route('csv', 4)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Voluntários e suas respectivas tarefas</td>
                            <td class="text-right">
                                <a href="{{route('relatorioVoluntarioTarefa')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                    </tbody>
                    <tbody id="6">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Autores
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioAutores')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
						<tr>
							<td>2</td>
							<td>Relatório de Autores (Lanche)
							</td>
							<td class="text-right">
								<a href="{{route('relatorioAutoresLanche')}}" target="_blank"><i class="material-icons">visibility</i></a>
							</td>
						</tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Autores (Pós Homologação)
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioAutoresPos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                                <a href="{{route('csvAutoresHomologados')}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Relatório de Autores Que Comparecerão na IFCITEC
                            </td>
                            <td class="text-right">
                                <a href="{{route('csvAutoresConfirmaramPresenca')}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Relatório de Avaliadores
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioAvaliadores')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Relatório de Coorientadores
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioCoorientadores')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Relatório de Coorientadores (Pós Homologação)
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioCoorientadoresPos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Relatório de Homologadores
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioHomologadores')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Relatório de Orientadores
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioOrientadores')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Relatório de Orientadores (Pós Homologação)
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioOrientadoresPos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Relatório de Voluntários
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioVoluntarios')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Reletório de Participantes de Projetos</td>
                            <td class="text-right">
                                <a href="{{route('csv', 3)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
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

    hideBodys();
    hideHeads();
    $('tbody[id=0]').show();
    $('thead[id=0]').show();
    $('div[id=0]').show();
    $('.tab').click(function (e) {
        var target = $(this)[0];
        hideBodys();
        hideHeads();
        $('tbody[id='+target.id+']').show();
        $('thead[id='+target.id+']').show();
        $('div[id='+target.id+']').show();
    });
});
    function hideBodys(){
    $('tbody[id=0]').hide();
    $('tbody[id=1]').hide();
    $('tbody[id=2]').hide();
    $('tbody[id=3]').hide();
    $('tbody[id=4]').hide();
    $('tbody[id=5]').hide();
    $('tbody[id=6]').hide();
    $('tbody[id=7]').hide();
    $('tbody[id=8]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();
    $('div[id=7]').hide();
    $('div[id=8]').hide();
}
function hideHeads(){
    $('thead[id=0]').hide();
    $('thead[id=1]').hide();
    $('thead[id=2]').hide();
    $('thead[id=3]').hide();
    $('thead[id=4]').hide();
    $('thead[id=5]').hide();
    $('thead[id=6]').hide();
    $('thead[id=7]').hide();
    $('thead[id=8]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();
    $('div[id=7]').hide();
    $('div[id=8]').hide();
}

</script>

@endsection
