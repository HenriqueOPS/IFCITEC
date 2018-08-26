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
                        <thead id="8">
                    <div id="8">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Relatórios</th>
                            <th class="text-right">Ações</th>
                        </tr>
                    </div>
                    </thead>

                    <tbody id="8">
                        <tr>
                            <td>1</td>
                            <td>Relatório de Áreas do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('relatorioArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Relatório de Autores, Orientadores, Coorientadores, Voluntários, Homologadores e Avaliadores por Edição
                            </td>
                            <td class="text-right">
                                <a href="{{route('relatorioUsuarios')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Relatório de Avaliadores</td>
                            <td class="text-right">
                                <a href="{{route('csv', 1)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Relatório de Avaliadores Por Área do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('avaliadoresArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Relatório de Avaliadores Por Projeto</td>
                            <td class="text-right">
                                <a href="{{route('avaliadoresProjeto')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Relatório de Classificação Geral dos Projetos</td>
                            <td class="text-right">
                                <a href="{{route('classificacaoProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Relatório de Edições</td>
                            <td class="text-right">
                                <a href="{{route('relatorioEdicao')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Relatório de Escolas</td>
                            <td class="text-right">
                                <a href="{{route('relatorioEscola')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Relatório de Homologadores</td>
                            <td class="text-right">
                                <a href="{{route('csv', 2)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Relatório de Homologadores Por Área do Conhecimento</td>
                            <td class="text-right">
                                <a href="{{route('homologadoresArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Relatório de Homologadores Por Projeto</td>
                            <td class="text-right">
                                <a href="{{route('homologadoresProjeto')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Relatório de Níveis</td>
                            <td class="text-right">
                                <a href="{{route('relatorioNivel')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Reletório de Participantes de Projetos</td>
                            <td class="text-right">
                                <a href="{{route('csv', 3)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Relatório de Projetos</td>
                            <td class="text-right">
                                <a href="{{route('relatorioProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Relatório de Projetos Classificados Para a {{\App\Edicao::numeroEdicao(\App\Edicao::find(\App\Edicao::getEdicaoId())->ano)}} Edição</td>
                            <td class="text-right">
                                <a href="{{route('projetosClassificados')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>Relatório de Premiação dos Projetos</td>
                            <td class="text-right">
                                <a href="{{route('premiacaoProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <td>17</td>
                            <td>Relatório de Projetos E Seus Status</td>
                            <td class="text-right">
                                <a href="{{route('statusProjetos')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>Relatório de Projetos Por Nota de Homologadores</td>
                            <td class="text-right">
                                <a href="{{route('notaProjetosArea')}}" target="_blank"><i class="material-icons">visibility</i></a>
                                <a href="{{route('csvProjetos')}}" target="_blank"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>Relatório de Projetos Que Comparecerão na IFCITEC</td>
                            <td class="text-right">
                                <a href="{{route('relatorioProjetosConfirma')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>Relatório de Usuários e suas respectivas funções</td>
                            <td class="text-right">
                                <a href="{{route('relatorioFuncoesUsuarios')}}" target="_blank"><i class="material-icons">visibility</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>21</td>
                            <td>Relatório de Voluntários</td>
                            <td class="text-right">
                                <a href="{{route('csv', 4)}}"><i class="material-icons">arrow_downward</i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td>Relatório de Voluntários e suas respectivas tarefas</td>
                            <td class="text-right">
                                <a href="{{route('relatorioVoluntarioTarefa')}}" target="_blank"><i class="material-icons">visibility</i></a>
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
