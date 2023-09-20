<?php

// Relatórios
Route::get('/relatorio/EscolaProjeto/{edicao}','RelatorioController@RelatorioPorEscola')->name('RelatorioPorEscola');
Route::get('/csv/{id}/{edicao?}', 'RelatorioController@csv')->name('csv');
Route::get('/projetos/csv', 'RelatorioController@csvCertificados')->name('csvCertificados');
Route::get('/pessoas/csv', 'RelatorioController@csvProjetos')->name('csvProjetos');
Route::get('/pessoas/csv/autores/homologados', 'RelatorioController@csvAutoresHomologados')->name('csvAutoresHomologados');
Route::get('/pessoas/csv/autores/confirmaram-presenca/{edicao}', 'RelatorioController@csvAutoresConfirmaramPresenca')->name('csvAutoresConfirmaramPresenca');
Route::get('/relatorio/projetos/compareceram/{edicao}', 'RelatorioController@projetosCompareceram')->name('projetosCompareceram');
Route::get('/relatorio/presenca/participantes/{edicao}', 'RelatorioController@participantesCompareceram')->name('participantesCompareceram');
Route::get('/relatorio/projetos/compareceram/ifrs/canoas/{edicao}', 'RelatorioController@projetosCompareceramIFRSCanoas')->name('projetosCompareceramIFRSCanoas');
Route::get('/relatorio/projetos/compareceram/autor/{edicao}', 'RelatorioController@projetosCompareceramPorAutor')->name('projetosCompareceramAutor');
Route::get('/relatorio/projetos/status/{edicao}', 'RelatorioController@statusProjetos')->name('statusProjetos');
Route::get('/relatorio/niveis/projetos/{id}', 'RelatorioController@nivelProjetos')->name('nivelProjetos');
Route::get('/relatorio/projetos/notas/homologadores', 'RelatorioController@notaProjetosArea')->name('notaProjetosArea');
Route::get('/relatorio/projetos/notas/homologadores/niveis', 'RelatorioController@notaProjetosNivel')->name('notaProjetosNivel');
Route::get('/relatorio/escolas/projetos/{id}', 'RelatorioController@escolaProjetos')->name('escolaProjetos');
Route::get('/relatorio/areas/projetos/{id}', 'RelatorioController@areaProjetos')->name('areaProjetos');
Route::get('/relatorio/funcoes/usuarios', 'RelatorioController@funcoesUsuarios')->name('relatorioFuncoesUsuarios');
Route::get('/relatorio/usuarios/homologados', 'RelatorioController@usuariosPosHomologacao')->name('usuariosPosHomologacao');
Route::get('/relatorio/tarefa/voluntarios/{id}', 'RelatorioController@tarefaVoluntarios')->name('tarefaVoluntarios');
Route::get('/relatorio/usuarios', 'RelatorioController@usuarios')->name('relatorioUsuarios');
Route::get('/relatorio/autores/{edicao}', 'RelatorioController@autores')->name('relatorioAutores');
Route::get('/relatorio/orientadores/{edicao}', 'RelatorioController@orientadores')->name('relatorioOrientadores');
Route::get('/relatorio/coorientadores/{edicao}', 'RelatorioController@coorientadores')->name('relatorioCoorientadores');
Route::get('/relatorio/voluntarios/{edicao}', 'RelatorioController@voluntarios')->name('relatorioVoluntarios');
Route::get('/relatorio/avaliadores/{edicao}', 'RelatorioController@avaliadores')->name('relatorioAvaliadores');
Route::get('/relatorio/autores/pos/homologacao/{edicao}', 'RelatorioController@autoresPosHomologacao')->name('relatorioAutoresPos');
Route::get('/relatorio/orientadores/pos/homologacao/{edicao}', 'RelatorioController@orientadoresPosHomologacao')->name('relatorioOrientadoresPos');
Route::get('/relatorio/orientadores/pos/homologacaocsv/{edicao}', 'RelatorioController@csvMailingOrientadoresPosHomologacao')->name('csvMailingOrientadoresPos');
Route::get('/relatorio/coorientadores/pos/homologacao/{edicao}', 'RelatorioController@coorientadoresPosHomologacao')->name('relatorioCoorientadoresPos');
Route::get('/relatorio/coorientadores/pos/homologacaocsv/{edicao}', 'RelatorioController@csvMailingCoorientadoresPosHomologacao')->name('csvMailingCoorientadoresPos');
Route::get('/relatorio/autores/tamanho/camisa/{edicao}', 'RelatorioController@camisaTamanho')->name('camisaTamanho');
Route::get('/relatorio/autores/tamanho/camisa/assinatura/{$edicao}', 'RelatorioController@camisaTamanhoAssinatura')->name('camisaTamanhoAssinatura');
Route::get('/relatorio/participantes/assinatura/{edicao}', 'RelatorioController@participantesAssinatura')->name('participantesAssinatura');
Route::get('/relatorio/projetos/confirma/{edicao}', 'RelatorioController@projetosConfirmaramPresenca')->name('relatorioProjetosConfirma');
Route::get('/relatorio/projetos/confirma/area/{edicao}', 'RelatorioController@projetosConfirmaramPresencaArea')->name('relatorioProjetosConfirmaArea');
Route::get('/relatorio/projetos/{edicao}', 'RelatorioController@projetos')->name('relatorioProjetos');
Route::get('/relatorio/projetos/{edicao}/area', 'RelatorioController@projetosAreas')->name('relatorioProjetosArea');
Route::get('/relatorio/mailing', 'RelatorioController@csvMailing')->name('csvMailing');
Route::get('/relatorio/idenficacao/{edicao}', 'RelatorioController@csvIdentificacaoMontagem')->name('csvIdentificacaoMontagem');

// Relatórios - Avaliação
Route::get('/relatorio/avaliadores/area/{edicao}', 'RelatorioController@avaliadoresArea')->name('avaliadoresArea');
Route::get('/relatorio/avaliadores/projeto/{edicao}', 'RelatorioController@avaliadoresProjeto')->name('avaliadoresProjeto');
Route::get('/relatorio/projetos/avaliador/{edicao}', 'RelatorioController@projetosAvaliador')->name('projetosAvaliador');

// Relatórios - Crachás
Route::get('/cracha/gerar-crachas/autores/{edicao}', 'CrachaController@generateCrachasAutores')->name('generateCrachasAutores');
Route::get('/cracha/gerar-crachas/autores-resumo/{edicao}', 'CrachaController@generateCrachasAutoresResumo')->name('generateCrachasAutoresResumo');
Route::get('/cracha/gerar-crachas/coorientadores/{edicao}', 'CrachaController@generateCrachasCoorientadores')->name('generateCrachasCoorientadores');
Route::get('/cracha/gerar-crachas/coorientadores-resumo/{edicao}', 'CrachaController@generateCrachasCoorientadoresResumo')->name('generateCrachasCoorientadoresResumo');
Route::get('/cracha/gerar-crachas/comissao-avaliadora/{edicao}', 'CrachaController@generateCrachasComissaoAvaliadora')->name('generateCrachasComissaoAvaliadora');
Route::get('/cracha/gerar-crachas/comissao-avaliadora-resumo/{edicao}', 'CrachaController@generateCrachasComissaoAvaliadoraResumo')->name('generateCrachasComissaoAvaliadoraResumo');
Route::get('/cracha/gerar-crachas/comissao-organizadora/{edicao}', 'CrachaController@generateCrachasComissaoOrganizadora')->name('generateCrachasComissaoOrganizadora');
Route::get('/cracha/gerar-crachas/comissao-organizadora-resumo/{edicao}', 'CrachaController@generateCrachasComissaoOrganizadoraResumo')->name('generateCrachasComissaoOrganizadoraResumo');
Route::get('/cracha/gerar-crachas/orientadores/{edicao}', 'CrachaController@generateCrachasOrientadores')->name('generateCrachasOrientadores');
Route::get('/cracha/gerar-crachas/orientadores-resumo/{edicao}', 'CrachaController@generateCrachasOrientadoresResumo')->name('generateCrachasOrientadoresResumo');
Route::get('/cracha/gerar-crachas/voluntarios/{edicao}', 'CrachaController@generateCrachasVoluntarios')->name('generateCrachasVoluntarios');
Route::get('/cracha/gerar-crachas/voluntarios-resumo/{edicao}', 'CrachaController@generateCrachasVoluntariosResumo')->name('generateCrachasVoluntariosResumo');
Route::get('/cracha/gerar-crachas/branco/{edicao}', 'CrachaController@generateCrachas')->name('generateCrachas');
Route::get('/cracha/qr-code/{id}', 'CrachaController@generateQrCode')->name('qrcode'); // QrCode image
Route::get('/relatorio', 'RelatorioController@funcoesSys')->name('relatorio.index');
Route::get('/relatorio/EmailOrientadoreseCoorientadores/{edicao}','RelatorioController@EmailOrientadoreseCoorientadores')->name('EmailOrientadoreseCoorientadores');
Route::get('/relatorio/NomeTelefoneAvaliadores','RelatorioController@NomeTelefoneAvaliadores')->name('NomeTelefoneAvaliadores');
// Relatórios - Gerais
Route::get('/csv/anais/ifcitec/{edicao}', 'RelatorioController@csvAnais')->name('csvAnais');
Route::get('/csv/mostratec/ifcitec/{edicao}', 'RelatorioController@csvMOSTRATEC')->name('csvMOSTRATEC');
Route::get('/relatorio/areas/{edicao}', 'RelatorioController@areas')->name('relatorioArea');
Route::get('/relatorio/csv/escolas', 'RelatorioController@csvEtiquetas')->name('csvEtiquetas');
Route::get('/relatorio/edicoes', 'RelatorioController@edicoes')->name('relatorioEdicao');
Route::get('/relatorio/escolas', 'RelatorioController@escolas')->name('relatorioEscola');
Route::get('/relatorio/empresa', 'RelatorioController@empresa')->name('relatorioEmpresa');
Route::get('/relatorio/niveis/{edicao}', 'RelatorioController@niveis')->name('relatorioNivel');
Route::get('escolasContato', 'RelatorioController@csvEmailNomeEscolas')->name('csvEmailNomeEscolas');
Route::get('/relatorio/escolas/tipo-escola', 'RelatorioController@escolaPorTipo')->name('relatorioEscolaPorTipo');
Route::get('/escolas/tipo-escola-csv', 'RelatorioController@csvEscolaPorTipo')->name('csvEscolaPorTipo');
Route::get('/relatorio/mostratec/{edicao}', 'RelatorioController@relatorioMOSTRATEC')->name('relatorioMOSTRATEC');
Route::get('/download-escolas-csv/{editionId}', 'RelatorioController@generateCSVForEdition')->name('download.relatorio.por.escola');
Route::get('/download/Homologadores/{id}','RelatorioController@GetRevisoesPorHomologador')->name('download.homologadores');
Route::get('/download/Avaliadores/{id}','RelatorioController@GetRevisoesPorAvaliadores')->name('download.avaliador');

// Relatórios - Lanche
Route::get('/relatorio/vale-lanche/gerar/{edicao}', 'RelatorioController@gerarValeLanche')->name('geraValeLanche');
Route::post('/relatorio/vale-lanche/{edicao}', 'RelatorioController@valeLanche')->name('valeLanche');

// Relatórios - Homologação
Route::get('/relatorio/homologadores/{edicao}', 'RelatorioController@homologadores')->name('relatorioHomologadores');
Route::get('/relatorio/homologadores/area/{edicao}', 'RelatorioController@homologadoresArea')->name('homologadoresArea');
Route::get('/relatorio/homologadores/projeto/{edicao}', 'RelatorioController@homologadoresProjeto')->name('homologadoresProjeto');
Route::get('/relatorio/projetos/classificados/area/{edicao}', 'RelatorioController@projetosClassificados')->name('projetosClassificados'); // TODO: revisar
Route::get('/relatorio/projetos/classificados/nivel/{edicao}', 'RelatorioController@projetosClassificadosNivel')->name('projetosClassificadosNivel');
Route::get('/relatorio/projetos/classificados/{edicao}', 'RelatorioController@projetosClassificadosSemNota')->name('projetosClassificadosSemNota');
Route::get('/relatorio/projetos/nao-homologados/nivel/{edicao}', 'RelatorioController@projetosNaoHomologadosNivel')->name('projetosNaoHomologadosNivel');

// Relatórios - Premiação
Route::get('/relatorio/projetos/classificacao/geral/{edicao}', 'RelatorioController@classificacaoGeral')->name('classificacaoGeral');
Route::get('/relatorio/projetos/classificacao/{edicao}', 'RelatorioController@classificacaoProjetos')->name('classificacaoProjetos');
Route::get('/relatorio/projetos/premiacao/{edicao}', 'RelatorioController@premiacaoProjetos')->name('premiacaoProjetos');
Route::get('/csv/projetos/premiacao/{edicao}', 'RelatorioController@csvPremiados')->name('csvPremiados'); // csv
Route::get('/relatorio/premiacao/certificados/{edicao}', 'RelatorioController@premiacaoCertificados')->name('premiacaoCertificados');
// Relatórios - Presença/Certficados
Route::get('/csv/presenca/partcipantes/{edicao}', 'RelatorioController@csvPresencaParticipantes')->name('csvPresencaParticipantes');
Route::get('/csv/presenca/avaliadores/{edicao}', 'RelatorioController@csvPresencaAvaliadores')->name('csvPresencaAvaliadores');
Route::get('/csv/presenca/coorientadores/{edicao}', 'RelatorioController@csvPresencaCoorientadores')->name('csvPresencaCoorientadores');
Route::get('/csv/presenca/orientadores/{edicao}', 'RelatorioController@csvPresencaOrientadores')->name('csvPresencaOrientadores');
Route::get('/csv/presenca/voluntarios/{edicao}', 'RelatorioController@csvPresencaVoluntarios')->name('csvPresencaVoluntarios');
Route::get('/csv/presenca/homologadores/{edicao}', 'RelatorioController@csvPresencaHomologadores')->name('csvPresencaHomologadores');

Route::get('/csv/presenca/comissao/organizadora', 'RelatorioController@csvPresencaComissaoOrganizadora')->name('csvPresencaComissao');

// Relatórios - Projetos
Route::get('/relatorio/gerar/localizacao/projetos/{edicao}', 'RelatorioController@gerarLocalizacaoProjetos')->name('gerarLocalizacaoProjetos');
Route::post('/relatorio/gera/localizacao/projetos/{edicao}', 'RelatorioController@geraLocalizacaoProjetos')->name('geraLocalizacaoProjetos');
Route::get('/relatorio/projetos/homologados-escola/{edicao}', 'RelatorioController@projetosHomologadosPorEscola')->name('projetosHomologadosPorEscola');
Route::get('/relatorio/projetos/concluintes-projeto/{edicao}', 'RelatorioController@alunosConcluintesPorProjeto')->name('concluintesPorProjeto');

// Relatórios - Voluntários
Route::get('/relatorio/voluntario/tarefa/{edicao}', 'RelatorioController@voluntarioTarefa')->name('relatorioVoluntarioTarefa');
