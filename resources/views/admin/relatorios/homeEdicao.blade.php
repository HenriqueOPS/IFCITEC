@extends('layouts.app')

@section('css')
    <style>
        .tab {
            font-size: 8.5pt !important;
        }
    </style>
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2>Painel administrativo</h2>
            </div>

            @include('partials.admin.navbar')
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
                                    Crachás
                                </a>
                            </li>
                            <li>
                                <a id="2" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">note</i>
                                    Gerais
                                </a>
                            </li>
                            <li>
                                <a id="3" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">description</i>
                                    Homologação
                                </a>
                            </li>
                            <li>
                                <a id="4" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">star</i>
                                    Premiação
                                </a>
                            </li>
                            <li>
                                <a id="5" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">location_on</i>
                                    Presença (Certificados)
                                </a>
                            </li>
                            <li>
                                <a id="6" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">school</i>
                                    Projetos
                                </a>
                            </li>
                            <li>
                                <a id="7" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">directions_run</i>
                                    Voluntários
                                </a>
                            </li>
                            <li>
                                <a id="8" role="tab" class="tab" data-toggle="tab">
                                    <i class="material-icons">group</i>
                                    Participantes
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
                                    <a href="{{ route('relatorioAvaliadores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csv', ['id' => 1, 'edicao' => $edicao]) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Relatório de Avaliadores Por Área do Conhecimento</td>
                                <td class="text-right">
                                    <a href="{{ route('avaliadoresArea', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Relatório de Avaliadores Por Projeto</td>
                                <td class="text-right">
                                    <a href="{{ route('avaliadoresProjeto', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Relatório de Projetos Por Avaliador</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosAvaliador', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                        </tbody>

                        <tbody id="1">
                            <tr>
                                <td>1</td>
                                <td>Crachás Autores</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasAutores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Crachás Coorientadores</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasCoorientadores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Crachás Comissão Avaliadora</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasComissaoAvaliadora', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Crachás Comissão Organizadora</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasComissaoOrganizadora', $edicao) }}"
                                        target="_blank"><i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Crachás Orientadores</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasOrientadores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Crachás Voluntários</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasVoluntarios', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Crachás Backup</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachas', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>

                            </tr>
                            
                            <tr>
                                <td>8</td>
                                <td>Etiqueta Crachás Autores</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasAutoresResumo', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Etiqueta Crachás Coorientadores</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasCoorientadoresResumo', $edicao) }}"
                                        target="_blank"><i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Etiqueta Crachás Comissão Avaliadora</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasComissaoAvaliadoraResumo', $edicao) }}"
                                        target="_blank"><i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Etiqueta Crachás Comissão Organizadora</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasComissaoOrganizadoraResumo', $edicao) }}"
                                        target="_blank"><i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Etiqueta Crachás Orientadores</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasOrientadoresResumo', $edicao) }}"
                                        target="_blank"><i class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Etiqueta Crachás Voluntários</td>
                                <td class="text-right">
                                    <a href="{{ route('generateCrachasVoluntariosResumo', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                        </tbody>

                        <tbody id="2">
                            <tr>
                                <td>1</td>
                                <td>Anais (Edição Corrente)</td>
                                <td class="text-right">
                                    <a href="{{ route('csvAnais', $edicao) }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Dados MOSTRATEC (Edição Corrente)</td>
                                <td class="text-right">
                                   
                                            <a href="{{ route('csvMOSTRATEC', $edicao) }}" target="_blank"><i
                                    class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Relatório de Áreas do Conhecimento</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioArea', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Relatório de Edições</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioEdicao') }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Relatório de Níveis</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioNivel', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Relatório de CSV das Etiquetas das Escolas</td>
                                <td class="text-right">
                                    <a href="{{ route('csvEtiquetas') }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Relatório de Escolas</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioEscola') }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Relatorio Escolas por Natureza</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioEscolaPorTipo') }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csvEscolaPorTipo') }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Relatorio em CSV com nome e email das escolas</td>
                                <td class="text-right">
                                    <a href="{{ route('csvEmailNomeEscolas') }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Relatório de Empresas</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioEmpresa') }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Vale Lanche</td>
                                <td class="text-right">
                                    <a href="{{ route('geraValeLanche', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                               <tr>
                                <td>12</td>
                                <td>Projetos Homologados por escola</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorio.index')}}" target="_blank">
                                        <i class="material-icons">arrow_downward</i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>


                        <tbody id="3">
                            <tr>
                                <td>1</td>
                                <td>Relatório de Homologadores</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioHomologadores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csv', ['id' => 2, 'edicao' => $edicao]) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Relatório de Homologadores Por Área do Conhecimento</td>
                                <td class="text-right">
                                    <a href="{{ route('homologadoresArea', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Relatório de Homologadores Por Projeto</td>
                                <td class="text-right">
                                    <a href="{{ route('homologadoresProjeto', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Relatório de Projetos Classificados Para a Edição Corrente (Por Área do Conhecimento)
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('projetosClassificados', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Relatório de Projetos Classificados Para a Edição Corrente (Por Nível)</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosClassificadosNivel', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Relatório de Projetos Classificados Para a Edição Corrente (Sem Notas)</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosClassificadosSemNota', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Relatório de Projetos Não Homologados Para a Edição Corrente (Por Nível)</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosNaoHomologadosNivel', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                        </tbody>

                        <tbody id="4">
                            <tr>
                                <td>1</td>
                                <td>Relatório de Classificação Geral dos Projetos</td>
                                <td class="text-right">
                                    <a href="{{ route('classificacaoGeral', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Relatório de Classificação Geral dos Projetos Por Área do Conhecimento</td>
                                <td class="text-right">
                                    <a href="{{ route('classificacaoProjetos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Relatório de Premiação dos Projetos</td>
                                <td class="text-right">
                                    <a href="{{ route('premiacaoProjetos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csvPremiados', $edicao) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Relatório de Premiação dos Projetos (Certificados)</td>
                                <td class="text-right">
                                    <a href="{{ route('premiacaoCertificados', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                          
                        </tbody>

                        <tbody id="5">
                            <tr>
                                <td>1</td>
                                <td>CSV Participantes</td>
                                <td class="text-right">
                                    <a href="{{ route('csvPresencaParticipantes', $edicao) }}"><i
                                             class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>CSV Comissão Organizadora</td>
                                <td class="text-right">
                                    <a href="{{ route('csvPresencaComissao') }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>CSV Voluntários</td>
                                <td class="text-right">
                                    <a href="{{ route('csvPresencaVoluntarios', $edicao) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Autores, Coorientadores, Orientadores e Voluntários que Compareceram na IFCITEC</td>
                                <td class="text-right">
                                    <a href="{{ route('participantesCompareceram', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                        </tbody>

                        <tbody id="6">
                            <tr>
                                <td>1</td>
                                <td>Gerar Localização dos Projetos</td>
                                <td class="text-right">
                                    <a href="{{ route('gerarLocalizacaoProjetos', $edicao) }}"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Relatório de Projetos</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioProjetos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>Relatório de Projetos por Nível e Área</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioProjetosArea', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>Relatório de Projetos E Seus Status</td>
                                <td class="text-right">
                                    <a href="{{ route('statusProjetos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>Relatório de Projetos Que Comparecerão (Edição Corrente)</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioProjetosConfirma', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>Relatório de Projetos Que Comparecerão na Edição Corrente (Por Área do Conhecimento)
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioProjetosConfirmaArea', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>7</td>
                                <td>Relatório de Projetos Que Compareceram (Edição Corrente)</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosCompareceram', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>8</td>
                                <td>Relatório de Projetos Que Compareceram do IFRS Canoas (Edição Corrente)</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosCompareceramIFRSCanoas', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>9</td>
                                <td>Relatório de Projetos Que Compareceram Por Autor (Edição Corrente)</td>
                                <td class="text-right">
                                    <a href="{{ route('projetosCompareceramAutor', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Gerar Identificação dos Projetos CSV</td>
                                <td class="text-right">
                                    <a href="{{ route('csvIdentificacaoMontagem', $edicao) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Concluintes por Projeto</td>
                                <td class="text-right">
                                    <a href="{{ route('concluintesPorProjeto', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Projetos Homologados por escola</td>
                                <td class="text-right">
                                    <a href="{{ route('RelatorioPorEscola', $edicao) }}" target="_blank"><i
                                    class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Projetos Homologados por escola</td>
                                <td class="text-right">
                                    <a href="{{ route('download.relatorio.por.escola', $edicao) }}" target="_blank">
                                        <i class="material-icons">arrow_downward</i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody id="7">
                            <tr>
                                <td>1</td>
                                <td>Relatório de Voluntários</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioVoluntarios', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csv', ['id' => 4, 'edicao' => $edicao]) }}"><i
                                           class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Relatório de Voluntários e suas respectivas tarefas</td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioVoluntarioTarefa', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                        </tbody>
                        <tbody id="8">
                            <tr>
                                <td>1</td>
                                <td>Relatório de Autores
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioAutores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Relatório de Autores (Pós Homologação)
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioAutoresPos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csvAutoresHomologados') }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Relatório de Autores (Tamanho Camisa)
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('camisaTamanho', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Relatório de Autores Que Comparecerão na IFCITEC
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('csvAutoresConfirmaramPresenca', $edicao) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Relatório de Coorientadores
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioCoorientadores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Relatório de Coorientadores (Pós Homologação)
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioCoorientadoresPos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csvMailingCoorientadoresPos', $edicao) }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Relatório de Orientadores
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioOrientadores', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Relatório de Orientadores (Pós Homologação)
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('relatorioOrientadoresPos', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                    <a href="{{ route('csvMailingOrientadoresPos', $edicao) }}" target="_blank"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Relatório de Participantes de Projetos</td>
                                <td class="text-right">
                                    <a href="{{ route('csv', ['id' => 3, 'edicao' => $edicao]) }}"><i
                                            class="material-icons">arrow_downward</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Relatório de Participantes (Assinatura)</td>
                                <td class="text-right">
                                    <a href="{{ route('participantesAssinatura', $edicao) }}" target="_blank"><i
                                            class="material-icons">visibility</i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>CSV Mailing Usuários</td>
                                <td class="text-right">
                                    <a href="{{ route('csvMailing') }}"><i class="material-icons">arrow_downward</i></a>
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
    <script src="{{ asset('js/main.js') }}"></script>
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
    $('tbody[id=9]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();
    $('div[id=7]').hide();
    $('div[id=8]').hide();
    $('div[id=9]').hide();
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
    $('thead[id=9]').hide();
    $('div[id=0]').hide();
    $('div[id=1]').hide();
    $('div[id=2]').hide();
    $('div[id=3]').hide();
    $('div[id=4]').hide();
    $('div[id=5]').hide();
    $('div[id=6]').hide();
    $('div[id=7]').hide();
    $('div[id=8]').hide();
    $('div[id=9]').hide();
}

document.getElementById('nav-relatorios').classList.add('active');

</script>
@endsection
