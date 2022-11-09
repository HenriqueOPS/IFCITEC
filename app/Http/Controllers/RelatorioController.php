<?php

namespace App\Http\Controllers;

use App\AreaConhecimento;
use App\Edicao;
use App\Enums\EnumFuncaoPessoa;
use App\Enums\EnumSituacaoProjeto;
use App\Escola;
use App\Nivel;
use App\Pessoa;
use App\Projeto;
use App\Tarefa;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RelatorioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * This function retuns a CSV file as data stream
     *
     * @param string     $filename    The name for file generated
     * @param array     $fileHeader Array with column labels
     * @param array     $fileRows    Array with arrays containing values for columns
     * @param string     $delimiter     The delimiter of CSV data
     *
     * @return stream     Returns CSV file stream
     */

    private function returnsCSVStream($filename, $fileHeader = [], $fileRows = [], $delimiter = ';')
    {
        $httpHeaders = [
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Expires' => '0',
            'Pragma' => 'public',
        ];

        $callback = function () use ($fileHeader, $fileRows, $delimiter) {
            $stream = fopen('php://output', 'w');

            if (count($fileHeader)) {
                fputcsv($stream, $fileHeader, ';');
            }

            foreach ($fileRows as $row) {
                fputcsv($stream, $row, $delimiter);
            }

            fclose($stream);
        };

        return response()->stream($callback, 200, $httpHeaders);
    }

    public function csv($id, $edicao)
    {
        $mapper = [
            1 => 'avaliadores',
            2 => 'homologadores',
            3 => 'participantes_projeto',
            4 => 'voluntarios',
            5 => 'projetos',
        ];

        $reportType = $mapper[$id] ?? $id;

        if ($reportType === 'avaliadores') {
            $resultados = DB::table('funcao_pessoa')
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->select('pessoa.email', 'pessoa.nome')
                ->where('funcao_pessoa.edicao_id', $edicao)
                ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
                ->where('funcao_pessoa.homologado', '=', true)
                ->get();

            $filename = "Avaliadores.csv";
        } else if ($id == 2) {
            $resultados = DB::table('funcao_pessoa')
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->select('pessoa.email', 'pessoa.nome')
                ->where('funcao_pessoa.edicao_id', $edicao)
                ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Homologador'))
                ->where('funcao_pessoa.homologado', '=', true)
                ->get();

            $filename = "Homologadores.csv";
        } else if ($id == 3) {
            $resultados = DB::table('funcao_pessoa')
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->select('pessoa.email', 'pessoa.nome')
                ->where('funcao_pessoa.edicao_id', $edicao)
                ->whereIn(
                    'funcao_pessoa.funcao_id',
                    [
                        EnumFuncaoPessoa::getValue('Autor'),
                        EnumFuncaoPessoa::getValue('Orientador'),
                        EnumFuncaoPessoa::getValue('Coorientador'),
                    ]
                )
                ->get();

            $filename = "ParticipantesProjeto.csv";
        } else if ($id == 4) {
            $resultados = DB::table('funcao_pessoa')
                ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->select('pessoa.email', 'pessoa.nome')
                ->where('funcao_pessoa.edicao_id', $edicao)
                ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Voluntario'))
                ->get();

            $filename = "Voluntarios.csv";
        } else if ($id == 5) {
            $resultados = DB::table('projeto')
                ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
                ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
                ->select('projeto.titulo', 'nivel.nivel', 'area_conhecimento.area_conhecimento')
                ->where('projeto.edicao_id', $edicao)
                ->get();

            $filename = "Projetos.csv";
        }

        $fileHeaders = [
            'Nome',
            'Email',
        ];

        $fileRows = [];
        foreach ($resultados as $row) {
            $rowData = [
                utf8_decode($row->nome),
                utf8_decode($row->email),
            ];

            array_push($fileRows, $rowData);
        }

        return $this->returnsCSVStream($filename, $fileHeaders, $fileRows);
    }

    public function csvMOSTRATEC($edicao)
    {
        $projetos = Projeto::select('projeto.id', 'projeto.titulo', 'escola.nome_completo', 'nivel.nivel', 'area_conhecimento.area_conhecimento', 'projeto.resumo')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('escola_funcao_pessoa_projeto.edicao_id', $edicao)
            ->where('projeto.situacao_id', '=', EnumSituacaoProjeto::getValue('Avaliado'))
            ->where('projeto.nota_avaliacao', '<>', 0)
            ->orderBy('nivel.nivel')
            ->orderBy('area_conhecimento.area_conhecimento')
            ->orderBy('projeto.titulo')
            ->distinct('projeto.id')
            ->get();

        $projetosComUmAutor = 0;
        $projetosComDoisAutores = 0;
        $projetosComTresAutores = 0;

        foreach ($projetos as $projeto) {
            $numAutores = count($projeto->getAutores());

            if ($numAutores == 1) {
                $projetosComUmAutor++;
            }

            if ($numAutores == 2) {
                $projetosComDoisAutores++;
            }

            if ($numAutores == 3) {
                $projetosComTresAutores++;
            }
        }

        $niveis = Nivel::all();

        $fileRows = [
            ['Projetos 01 Aluno', $projetosComUmAutor],
            ['Projetos 02 Alunos', $projetosComDoisAutores],
            ['Projetos 03 Alunos', $projetosComTresAutores],
        ];

        // numero de orientadores e coorientadores por nivel
        foreach ($niveis as $nivel) {
            $orientadores = Pessoa::select('pessoa.id')
                ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
                ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
                ->where('projeto.situacao_id', '=', EnumSituacaoProjeto::getValue('Avaliado'))
                ->where('projeto.nota_avaliacao', '<>', 0)
                ->where('projeto.nivel_id', $nivel->id)
                ->where('escola_funcao_pessoa_projeto.funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
                ->distinct('pessoa.id')
                ->count();

            array_push(
                $fileRows,
                ['Quantidade de Orientadores do nivel ' . $nivel->nivel, $orientadores]
            );

            $coorientadores = Pessoa::select('pessoa.id')
                ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
                ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
                ->where('projeto.situacao_id', '=', EnumSituacaoProjeto::getValue('Avaliado'))
                ->where('projeto.nota_avaliacao', '<>', 0)
                ->where('projeto.nivel_id', $nivel->id)
                ->where('escola_funcao_pessoa_projeto.funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
                ->distinct('pessoa.id')
                ->count();

            array_push(
                $fileRows,
                ['Quantidade de Coorientadores do nivel ' . $nivel->nivel, $coorientadores]
            );
        }

        // numero de escolas
        $countEscolas = DB::table('escola_funcao_pessoa_projeto')
            ->selectRaw('count(distinct escola_id) as num')
            ->where('edicao_id', '=', $edicao)
            ->distinct('escola_id')
            ->get();

        array_push(
            $fileRows,
            ['Quantidade de escolas participantes', $countEscolas[0]->num]
        );

        // numero de escolas por nivel
        foreach ($niveis as $nivel) {
            $countEscolasNivel = Projeto::selectRaw('count(distinct escola_funcao_pessoa_projeto.escola_id) as num')
                ->join('escola_funcao_pessoa_projeto', 'projeto_id', '=', 'projeto.id')
                ->where('projeto.edicao_id', '=', $edicao)
                ->where('projeto.nivel_id', '=', $nivel->id)
                ->get();

            array_push(
                $fileRows,
                ['Quantidade de Escolas no nivel ' . $nivel->nivel, $countEscolasNivel[0]->num]
            );
        }

        // numero de projetos
        $countProjetos = Projeto::select('projeto.id')
            ->where('edicao_id', $edicao)
            ->count();

        array_push(
            $fileRows,
            ['Projetos cadastrados', $countProjetos]
        );

        // numero de projetos por niveis
        foreach ($niveis as $nivel) {
            $countProjetosNivel = Projeto::select('projeto.id')
                ->where('edicao_id', $edicao)
                ->where('nivel_id', '=', $nivel->id)
                ->count();

            array_push(
                $fileRows,
                ['Projetos cadastrados no nivel ' . $nivel->nivel, $countProjetosNivel]
            );
        }

        // numero de avaliadores
        $countAvaliadores = DB::table('funcao_pessoa')
            ->where('funcao_id', '=', EnumFuncaoPessoa::getValue('Avaliador'))
            ->where('edicao_id', '=', $edicao)
            ->where('homologado', '=', true)
            ->count();

        array_push(
            $fileRows,
            ['Numero de avaliadores', $countAvaliadores]
        );

        // numero de homologadores
        $countHomologadores = DB::table('funcao_pessoa')
            ->where('funcao_id', '=', EnumFuncaoPessoa::getValue('Homologador'))
            ->where('edicao_id', '=', $edicao)
            ->where('homologado', '=', true)
            ->count();

        array_push(
            $fileRows,
            ['Numero de homologadores', $countHomologadores]
        );

        $filename = "RelatorioMOSTRATEC.csv";
        $fileHeaders = null;

        return $this->returnsCSVStream($filename, $fileHeaders, $fileRows);
    }

    public function csvAnais($edicao)
    {

        $projetos = Projeto::select('projeto.id', 'projeto.titulo', 'escola.nome_completo', 'nivel.nivel', 'area_conhecimento.area_conhecimento', 'projeto.resumo')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('escola_funcao_pessoa_projeto.edicao_id', $edicao)
            ->where('projeto.situacao_id', '=', EnumSituacaoProjeto::getValue('Avaliado'))
            ->where('projeto.nota_avaliacao', '<>', 0)
            ->orderBy('nivel.nivel')
            ->orderBy('area_conhecimento.area_conhecimento')
            ->orderBy('projeto.titulo')
            ->distinct('projeto.id')
            ->get();

        $filename = "RelatorioAnais.csv";

        $handle = fopen($filename, 'w+');

        $nivel = utf8_decode('Nível');
        $area = utf8_decode('Área do Conhecimento');

        fputcsv($handle, array('Projeto', 'Integrantes', 'Escola', $nivel, $area, 'Resumo', 'Palavras-Chave'), ';');

        foreach ($projetos as $projeto) {
            $integrantes = '';

            foreach ($projeto->getAutores() as $autor) {
                $integrantes .= $autor->nome . ' (Autor), ';
            }

            foreach ($projeto->getOrientador() as $orientador) {
                $integrantes .= ', ' . $orientador->nome . ' (Coordenador)';
            }

            foreach ($projeto->getCoorientadores() as $coorientador) {
                $integrantes .= ', ' . $coorientador->nome . ' (Coorientador)';
            }

            // palavras-chave
            $palavras = DB::table('palavra_chave')
                ->join('palavra_projeto', 'palavra_chave.id', '=', 'palavra_projeto.palavra_id')
                ->join('projeto', 'palavra_projeto.projeto_id', '=', 'projeto.id')
                ->select('palavra_chave.palavra')
                ->where('projeto.id', $projeto->id)
                ->get();

            $palavrasChave = '';
            foreach ($palavras as $palavra) {
                $palavrasChave .= utf8_decode($palavra->palavra) . ', ';
            }

            $titulo = utf8_decode($projeto->titulo);
            $integrantes = utf8_decode($integrantes);
            $nivel = utf8_decode($projeto->nivel);
            $area_conhecimento = utf8_decode($projeto->area_conhecimento);
            $escola = utf8_decode($projeto->nome_completo);
            $resumo = utf8_decode($projeto->resumo);
            $resumo = str_replace('&#34;', '"', $resumo);
            $titulo = str_replace('&#34;', '"', $titulo);

            fputcsv($handle, [
                $titulo,
                $integrantes,
                $escola,
                $nivel,
                $area_conhecimento,
                $resumo,
                $palavrasChave,
            ], ';');
        }

        fclose($handle);
        $headers = ['Content-Type' => 'text/csv'];

        return Response::download($filename, $filename, $headers);
    }

    public function csvPremiados($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        $filename = "ProjetosPremiados.csv";

        $handle = fopen($filename, 'w+');

        $nivel = utf8_decode('Nível');
        $area = utf8_decode('Área do Conhecimento');
        $colocacao = utf8_decode('Colocação');
        $funcao = utf8_decode('Função');
        fputcsv($handle, ['Projeto', $nivel, $area, 'Nota', $colocacao, $funcao, 'Integrante', 'Email'], ';');

        foreach ($areas as $area) {

            $projetos = $area->getClassificacaoProjetosCertificados($area->id, $edicao);
            $cont = count($projetos);

            foreach ($projetos as $projeto) {
                if ($cont == 3) {
                    $colocacao = 'TERCEIRO LUGAR';
                }

                if ($cont == 2) {
                    $colocacao = 'SEGUNDO LUGAR';
                }

                if ($cont == 1) {
                    $colocacao = 'PRIMEIRO LUGAR';
                }

                $cont--;

                foreach ($projeto->pessoas as $pessoa) {
                    if ($pessoa->temFuncaoProjeto('Autor', $projeto->id, $pessoa->id, $edicao)) {
                        $funcao = 'Autor';
                    }

                    if ($pessoa->temFuncaoProjeto('Orientador', $projeto->id, $pessoa->id, $edicao)) {
                        $funcao = 'Orientador';
                    }

                    if ($pessoa->temFuncaoProjeto('Coorientador', $projeto->id, $pessoa->id, $edicao)) {
                        $funcao = 'Coorientador';
                    }

                    $titulo = utf8_decode($projeto->titulo);
                    $nivel = utf8_decode($area->niveis->nivel);
                    $area_conhecimento = utf8_decode($area->area_conhecimento);
                    $participante = utf8_decode($pessoa->nome);
                    $email = utf8_decode($pessoa->email);

                    fputcsv($handle, [$titulo, $nivel, $area_conhecimento, $projeto->nota_avaliacao, $colocacao, $funcao, $participante, $email], ';');
                }
            }
        }

        fclose($handle);

        $headers = ['Content-Type' => 'text/csv'];

        return Response::download($filename, $filename, $headers);
    }

    public function csvProjetos()
    {
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id', '=', DB::raw('projeto.id'))
            ->toSql();

        $resultados = Projeto::select(
            'projeto.id',
            'titulo',
            'situacao_id',
            'nivel.nivel',
            'area_conhecimento.area_conhecimento',
            DB::raw('(' . $subQuery . ') as nota')
        )
            ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
            ->orderBy('nivel', 'asc')
            ->orderBy('area_conhecimento', 'asc')
            ->orderBy('nota', 'desc')
            ->get();

        $filename = "ProjetosNotasHomologadores.csv";

        $handle = fopen($filename, 'w+');
        $nivel = utf8_decode('Nível');
        $area = utf8_decode('Área do Conhecimento');
        fputcsv($handle, array('Projeto', $nivel, $area, 'Nota Final'), ';');

        foreach ($resultados as $row) {
            $titulo = utf8_decode($row->titulo);
            $nivel = utf8_decode($row->nivel);
            $area = utf8_decode($row->area_conhecimento);
            fputcsv($handle, array($titulo, $nivel, $area, $row->nota), ';');
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers);
    }

    public function csvEtiquetas()
    {
        $filename = "EscolasEtiquetas.csv";

        $escolas = DB::table('escola')
            ->select('*')
            ->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
            ->orderBy('escola.nome_curto')
            ->get();

        $handle = fopen($filename, 'w+');
        $endereco = utf8_decode('Endereço');
        $municipio = utf8_decode('Município');
        fputcsv($handle, ['Escola', 'Email', 'Telefone', $endereco, $municipio, 'Estado', 'CEP'], ';');

        foreach ($escolas as $escola) {
            fputcsv($handle, [
                utf8_decode($escola->nome_curto),
                $escola->email,
                $escola->telefone,
                utf8_decode($escola->endereco) . ', ' . utf8_decode($escola->numero),
                utf8_decode($escola->municipio),
                utf8_decode($escola->uf),
                $escola->cep,
            ], ';');
        }

        fclose($handle);
        $headers = ['Content-Type' => 'text/csv'];

        return Response::download($filename, $filename, $headers);
    }

    public function csvAutoresConfirmaramPresenca($edicao)
    {
        $resultados = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.email')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->where('projeto.presenca', true)
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $filename = "AutoresConfirmaramPresenca.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('Nome', 'Email'), ';');

        foreach ($resultados as $row) {
            $nome = utf8_decode($row->nome);
            fputcsv($handle, array($nome, $row->email), ';');
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers);
    }

    public function csvAutoresHomologados()
    {
        $resultados = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.email')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $filename = "AutoresHomologados.csv";
        $fileheaders = [
            "Nome",
            "Email",
        ];

        $fileRows = [];
        foreach ($resultados as $row) {
            $rowData = [
                utf8_decode($row->nome),
                utf8_decode($row->email),
            ];

            array_push($fileRows, $rowData);
        }

        return $this->returnsCSVStream($filename, $fileheaders, $fileRows);
    }

    public function participantesCompareceram($edicao)
    {
        $autores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->where('escola_funcao_pessoa_projeto.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->where('projeto.nota_avaliacao', '<>', 0)
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Avaliado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->distinct('pessoa.id')
            ->get();

        $coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
            ->where('escola_funcao_pessoa_projeto.funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Avaliado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                ]
            )
            ->where('projeto.nota_avaliacao', '<>', 0)
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
            ->where('escola_funcao_pessoa_projeto.funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Avaliado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                ]
            )
            ->where('projeto.nota_avaliacao', '<>', 0)
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('presenca', 'pessoa.id', '=', 'presenca.id_pessoa')
            ->select('pessoa.nome', 'pessoa.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Voluntario'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        return PDF::loadView(
            'relatorios.participantesCompareceram',
            [
                'autores' => $autores,
                'coorientadores' => $coorientadores,
                'orientadores' => $orientadores,
                'voluntarios' => $voluntarios,
            ]
        )->download('participantes_compareceram.pdf');
    }

    /*
     *  Gera o CSV de certificados de acordo com a presença do PROJETO
     * */
    public function generateCSVByFunction($funcaoId, $edicaoId, $filename = 'relatorio.csv')
    {
        $participantes = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->where('funcao_pessoa.funcao_id', $funcaoId)
            ->where('escola_funcao_pessoa_projeto.funcao_id', $funcaoId)
            ->where('projeto.nota_avaliacao', '<>', 0) // presença dada pela nota de avaliação diferente de zero
            ->where('funcao_pessoa.edicao_id', '=', $edicaoId)
            ->where('projeto.edicao_id', '=', $edicaoId)
            ->orderBy('pessoa.nome')
            ->get();

        $headerFields = [
            'NOME_PARTICIPANTE',
            'EMAIL_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'PROJETO_PARTICIPANTE',
        ];

        $rows = [];
        foreach ($participantes as $participante) {
            array_push($rows, [
                utf8_decode($participante->nome),
                utf8_decode($participante->email),
                $participante->cpf,
                $participante->rg,
                utf8_decode($participante->titulo),
            ]);
        }

        return $this->returnsCSVStream($filename, $headerFields, $rows);
    }

    /*
     *  Gera o CSV de certificados para os AUTORES de acordo com a presença do PROJETO
     * */
    public function csvPresencaAutores($edicaoId)
    {
        $authorId = EnumFuncaoPessoa::getValue('Autor');
        $filename = 'RelatorioPresencaAutores.csv';

        return $this->generateCSVByFunction($authorId, $edicaoId, $filename);
    }

    /*
     *  Gera o CSV de certificados para os COORIENTADORES de acordo com a presença do PROJETO
     * */
    public function csvPresencaCoorientadores($edicaoId)
    {
        $coorientadorId = EnumFuncaoPessoa::getValue('Coorientador');
        $filename = 'RelatorioPresencaCoorientadores.csv';

        return $this->generateCSVByFunction($coorientadorId, $edicaoId, $filename);
    }

    /*
     *  Gera o CSV de certificados para os ORIENTADORES de acordo com a presença do PROJETO
     * */
    public function csvPresencaOrientadores($edicaoId)
    {
        $orientadorId = EnumFuncaoPessoa::getValue('Orientador');
        $filename = 'RelatorioPresencaOrientadores.csv';

        return $this->generateCSVByFunction($orientadorId, $edicaoId, $filename);
    }

    public function csvPresencaAvaliadores($edicao)
    {
        $subQuery = DB::raw('SELECT count(*)
			FROM presenca
			WHERE presenca.id_pessoa = pessoa.id AND
				projeto.edicao_id = presenca.edicao_id');

        $avaliadores = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('avaliacao', 'pessoa.id', '=', 'avaliacao.pessoa_id')
            ->join('projeto', 'avaliacao.projeto_id', '=', 'projeto.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
            ->where('funcao_pessoa.edicao_id', '=', $edicao)
            ->where('projeto.edicao_id', '=', $edicao)
            ->where(DB::raw('(' . $subQuery . ')'), '>', 0)
            ->orderBy('pessoa.nome')
            ->get();

        $header = [
            'NOME_PARTICIPANTE',
            'EMAIL_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'RG_PARTICIPANTE',
            'PROJETO_PARTICIPANTE',
        ];

        $rows = [];
        foreach ($avaliadores as $avaliador) {
            array_push($rows, [
                utf8_decode($avaliador->nome),
                utf8_decode($avaliador->email),
                $avaliador->cpf,
                $avaliador->rg,
                utf8_decode($avaliador->titulo),
            ]);
        }

        $filename = 'RelatorioPresencaAvaliadores.csv';
        return $this->returnsCSVStream($filename, $header, $rows);
    }

    public function csvPresencaVoluntarios($edicao)
    {
        $subQuery = DB::raw('SELECT count(*)
			FROM presenca
			WHERE presenca.id_pessoa = pessoa.id AND
				funcao_pessoa.edicao_id = presenca.edicao_id');

        $voluntarios = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('presenca', 'pessoa.id', '=', 'presenca.id_pessoa')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Voluntario'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where(DB::raw('(' . $subQuery . ')'), '>', 0)
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $header = [
            'NOME_PARTICIPANTE',
            'EMAIL_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'RG_PARTICIPANTE',
        ];

        $rows = [];
        foreach ($voluntarios as $voluntario) {
            array_push($rows, [
                utf8_decode($voluntario->nome),
                utf8_decode($voluntario->email),
                $voluntario->cpf,
                $voluntario->rg,
            ]);
        }

        $filename = 'RelatorioPresencaVoluntarios.csv';
        return $this->returnsCSVStream($filename, $header, $rows);
    }

    public function csvPresencaHomologadores($edicao)
    {

        $subQuery = DB::raw('SELECT count(*)
			FROM revisao
			WHERE revisao.pessoa_id = pessoa.id AND
				revisao.projeto_id = projeto.id');

        $homologadores = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('revisao', 'pessoa.id', '=', 'revisao.pessoa_id')
            ->join('projeto', 'revisao.projeto_id', '=', 'projeto.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Homologador'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.edicao_id', '=', $edicao)
            ->where(DB::raw('(' . $subQuery . ')'), '>', 0)
            ->orderBy('pessoa.nome')
            ->get();

        $header = [
            'NOME_PARTICIPANTE',
            'EMAIL_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'RG_PARTICIPANTE',
            'PROJETO_PARTICIPANTE',
        ];

        $rows = [];
        foreach ($homologadores as $homologador) {
            array_push($rows, [
                utf8_decode($homologador->nome),
                utf8_decode($homologador->email),
                $homologador->cpf,
                $homologador->rg,
                utf8_decode($homologador->titulo),
            ]);
        }

        $filename = 'RelatorioPresencaHomologaores.csv';
        return $this->returnsCSVStream($filename, $header, $rows);
    }

    public function csvPresencaComissaoOrganizadora()
    {
        $comissao = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->whereIn(
                'funcao_pessoa.funcao_id',
                [
                    EnumFuncaoPessoa::getValue('Administrador'),
                    EnumFuncaoPessoa::getValue('Organizador'),
                ]
            )
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $header = [
            'NOME_PARTICIPANTE',
            'EMAIL_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'RG_PARTICIPANTE',
        ];

        $rows = [];
        foreach ($comissao as $c) {
            array_push($rows, [
                utf8_decode($c->nome),
                utf8_decode($c->email),
                $c->cpf,
                $c->rg,
            ]);
        }

        $filename = 'RelatorioPresencaComissao.csv';
        return $this->returnsCSVStream($filename, $header, $rows);
    }

    public function notaProjetosArea()
    {
        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id', '=', DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(
            'projeto.id',
            'titulo',
            'situacao_id',
            'nivel.nivel',
            'area_conhecimento.area_conhecimento',
            DB::raw('(' . $subQuery . ') as nota')
        )
            ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
            ->orderBy('nivel', 'asc')
            ->orderBy('area_conhecimento', 'asc')
            ->orderBy('nota', 'desc')
            ->get();

        return PDF::loadView('relatorios.notaProjetosArea', ['projetos' => $projetos])
            ->setPaper('A4', 'landscape')
            ->download('nota_projetos_cadastrados.pdf');
    }

    public function notaProjetosNivel()
    {
        $niveis = Edicao::find(Edicao::getEdicaoId())->niveis;

        return PDF::loadView('relatorios.notaProjetosNivel', ['niveis' => $niveis])
            ->setPaper('A4', 'landscape')
            ->download('nota_projetos_cadastrados.pdf');
    }

    public function projetosClassificados($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        //return PDF::loadView('relatorios.homologacao.projetosClassificados', ['areas' => $areas, 'edicao' => $edicao])
        //->setPaper('A4', 'landscape')
        //->download('projetos_classificados_area.pdf');
        //}
        return view('relatorios.homologacao.projetosClassificados', ['areas' => $areas, 'edicao' => $edicao]);
    }

    public function projetosClassificadosNivel($edicao)
    {
        $niveis = Edicao::find($edicao)->niveis;

        //return PDF::loadView('relatorios.homologacao.projetosClassificadosNivel', ['niveis' => $niveis, 'edicao' => $edicao])
        //->setPaper('A4', 'landscape')
        //->download('projetos_classificados_nivel.pdf');
        return view('relatorios.homologacao.projetosClassificadosNivel', ['niveis' => $niveis, 'edicao' => $edicao]);
    }

    public function projetosNaoHomologadosNivel($edicao)
    {

        $niveis = Edicao::find($edicao)->niveis;

        //return PDF::loadView('relatorios.homologacao.projetosNaoHomologadosNivel', ['niveis' => $niveis, 'edicao' => $edicao])
        //->setPaper('A4', 'landscape')
        //->download('projetos_nao_homologados_nivel.pdf');
        return view('relatorios.homologacao.projetosNaoHomologadosNivel', ['niveis' => $niveis, 'edicao' => $edicao]);
    }

    public function projetosClassificadosSemNota($edicao)
    {

        $projetos = Projeto::select('projeto.titulo', 'projeto.situacao_id')
            ->where('projeto.edicao_id', '=', $edicao)
            ->where('projeto.situacao_id', '=', EnumSituacaoProjeto::getValue('Homologado'))
            ->orderBy('projeto.titulo', 'asc')
            ->get();

        //return PDF::loadView('relatorios.homologacao.projetosClassificadosSemNota', array('projetos' => $projetos, 'edicao' => $edicao))->download('projetos_classificados.pdf');
        return view('relatorios.homologacao.projetosClassificadosSemNota', array('projetos' => $projetos, 'edicao' => $edicao));
    }

    public function niveis($edicao)
    {
        $niveis = Edicao::find($edicao)->niveis;

        return PDF::loadView('relatorios.gerais.niveis', ['niveis' => $niveis])
            ->setPaper('A4', 'landscape')
            ->download('niveis.pdf');
    }

    public function escolas()
    {
        $escolas = Escola::select('*')
            ->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
            ->orderBy('escola.nome_curto')
            ->get();

        return PDF::loadView('relatorios.gerais.escolas', ['escolas' => $escolas])
            ->download('escolas.pdf');
    }

    public function autores($edicao)
    {
        $autores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->get();

        $cont = 0;

        /*
        return PDF::loadView('relatorios.autores', ['autores' => $autores, 'cont' => $cont, 'edicao' => $edicao])
        ->download('autores.pdf');
         */

        return view('relatorios.autores', ['autores' => $autores, 'cont' => $cont, 'edicao' => $edicao]);
    }

    public function orientadores($edicao)
    {
        $orientadores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->get();

        $cont = 0;

        /*
        return PDF::loadView('relatorios.orientadores', ['orientadores' => $orientadores, 'cont' => $cont, 'edicao' => $edicao])
        ->download('orientadores.pdf');
         */

        return view('relatorios.orientadores', ['orientadores' => $orientadores, 'cont' => $cont, 'edicao' => $edicao]);
    }

    public function coorientadores($edicao)
    {
        $coorientadores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->get();

        $cont = 0;

        //return PDF::loadView('relatorios.coorientadores', array('coorientadores' => $coorientadores, 'cont' => $cont, 'edicao' => $edicao))->download('coorientadores.pdf');
        return view('relatorios.coorientadores', array('coorientadores' => $coorientadores, 'cont' => $cont, 'edicao' => $edicao));
    }

    public function voluntarios($edicao)
    {
        $voluntarios = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Voluntario'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->get();

        $cont = 0;

        //return PDF::loadView('relatorios.voluntarios', array('voluntarios' => $voluntarios, 'cont' => $cont, 'edicao' => $edicao))->download('voluntarios.pdf');
        return view('relatorios.voluntarios', array('voluntarios' => $voluntarios, 'cont' => $cont, 'edicao' => $edicao));
    }

    public function homologadores($edicao)
    {
        $homologadores = DB::table('funcao_pessoa')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Homologador'))
            ->where('funcao_pessoa.edicao_id', '=', $edicao)
            ->where('funcao_pessoa.homologado', '=', true)
            ->orderBy('pessoa.nome')
            ->get();

        /*
        return PDF::loadView(
        'relatorios.homologacao.homologadores',
        [
        'homologadores' => $homologadores,
        'edicao' => $edicao,
        ]
        )->download('homologadores.pdf');
         */

        return view(
            'relatorios.homologacao.homologadores',
            [
                'homologadores' => $homologadores,
                'edicao' => $edicao,
            ]
        );
    }

    public function avaliadores($edicao)
    {
        $avaliadores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('funcao_pessoa.homologado', '=', true)
            ->orderBy('pessoa.nome')
            ->get();

        $cont = 0;

        /*
        return PDF::loadView(
        'relatorios.avaliadores',
        [
        'avaliadores' => $avaliadores,
        'cont' => $cont,
        'edicao' => $edicao,
        ]
        )->download('avaliadores.pdf');
         */

        return view(
            'relatorios.avaliadores',
            [
                'avaliadores' => $avaliadores,
                'cont' => $cont,
                'edicao' => $edicao,
            ]
        );
    }

    public function projetosAvaliador($edicao)
    {
        $avaliadores = Pessoa::select('pessoa.nome', 'pessoa.id')
            ->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
            ->where('funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('funcao_pessoa.homologado', true)
            ->orderBy('pessoa.nome')
            ->get();

        /*
        return PDF::loadView(
        'relatorios.avaliacao.projetosAvaliador',
        [
        'avaliadores' => $avaliadores,
        'edicao' => $edicao,
        ]
        )->download('projetos_avaliador.pdf');
         */
        return view(
            'relatorios.avaliacao.projetosAvaliador',
            [
                'avaliadores' => $avaliadores,
                'edicao' => $edicao,
            ]
        );
    }

    public function autoresPosHomologacao($edicao)
    {
        $autores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $cont = 0;

        /*
        return PDF::loadView(
            'relatorios.autoresPosHomologacao',
            [
                'autores' => $autores,
                'cont' => $cont,
                'edicao' => $edicao,
            ]
        )->download('autores_pos_homologacao.pdf');
        */
        return view(
            'relatorios.autoresPosHomologacao',
            [
                'autores' => $autores,
                'cont' => $cont,
                'edicao' => $edicao,
            ]
        );
    }

    public function camisaTamanho($edicao)
    {
        $autores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.camisa')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        /*
        return PDF::loadView(
            'relatorios.camisaTamanho',
            [
                'autores' => $autores,
                'edicao' => $edicao,
            ]
        )->download('autores_tamanho_camisa.pdf');
        */
        return view(
            'relatorios.camisaTamanho',
            [
                'autores' => $autores,
                'edicao' => $edicao,
            ]
        );
    }

    public function participantesAssinatura($edicao)
    {
        $autores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.id')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $orientadores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.id')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $coorientadores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.id')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        //return PDF::loadView('relatorios.participantesAssinatura', array('autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('participantes_assinatura.pdf');
        return view('relatorios.participantesAssinatura',  array('autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores, 'edicao' => $edicao));
    }

    public function orientadoresPosHomologacao($edicao)
    {
        $orientadores = DB::table('funcao_pessoa')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $cont = 0;

        //return PDF::loadView('relatorios.orientadoresPosHomologacao', array('orientadores' => $orientadores, 'cont' => $cont, 'edicao' => $edicao))->download('orientadores_pos_homologacao.pdf');
        return view('relatorios.orientadoresPosHomologacao', array('orientadores' => $orientadores, 'cont' => $cont, 'edicao' => $edicao));
    }

    public function coorientadoresPosHomologacao($edicao)
    {
        $coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $cont = 0;

        //return PDF::loadView('relatorios.coorientadoresPosHomologacao', array('coorientadores' => $coorientadores, 'cont' => $cont, 'edicao' => $edicao))->download('coorientadores_pos_homologacao.pdf');
        return view('relatorios.coorientadoresPosHomologacao', array('coorientadores' => $coorientadores, 'cont' => $cont, 'edicao' => $edicao));
    }

    public function projetosAreas($edicao)
    {
        $niveis = DB::table('nivel')
            ->select('nivel.id', 'nivel.nivel')
            ->join('nivel_edicao', 'nivel_edicao.nivel_id', '=', 'nivel.id')
            ->where('nivel_edicao.edicao_id', '=', $edicao)
            ->get()
            ->toArray();

        $projetosNivelArea = [];
        foreach ($niveis as $nivel) {

            $areas = DB::table('area_conhecimento')
                ->select('area_conhecimento.area_conhecimento', 'area_conhecimento.id')
                ->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
                ->where('area_edicao.edicao_id', '=', $edicao)
                ->where('area_conhecimento.nivel_id', '=', $nivel->id)
                ->orderBy('area_conhecimento.area_conhecimento')
                ->get()
                ->toArray();

            $projetosArea = [];
            foreach ($areas as $area) {

                $projetos = Projeto::where('edicao_id', '=', $edicao)
                    ->where('area_id', '=', $area->id)
                    ->where('nivel_id', '=', $nivel->id)
                    ->get();

                array_push($projetosArea, [
                    'area' => $area,
                    'projetos' => $projetos,
                ]);
            }

            array_push($projetosNivelArea, [
                'nivel' => $nivel,
                'projetosArea' => $projetosArea,
            ]);
        }

        //return PDF::loadView('relatorios.projetosAreas', compact('projetosNivelArea'))
        //->download('projetos_area.pdf');
        return view('relatorios.projetosAreas', compact('projetosNivelArea'));
    }

    public function projetos($edicao)
    {
        $projetos = Projeto::select('projeto.titulo', 'projeto.id', 'escola_funcao_pessoa_projeto.escola_id', 'situacao_id')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->where('projeto.edicao_id', '=', $edicao)
            ->distinct('projeto.id')
            ->orderBy('titulo')
            ->get();

        $projetosCadastrados = ['projetos' => array(), 'total' => 0, 'name' => 'Cadastrados'];
        $projetosNaoHomologados = ['projetos' => array(), 'total' => 0, 'name' => 'Não Homologados'];
        $projetosHomologados = ["projetos" => array(), "total" => 0, "name" => "Homologados"];
        $projetosNaoAvaliados = ["projetos" => array(), "total" => 0, "name" => "Não Avaliados"];
        $projetosAvaliados = ["projetos" => array(), "total" => 0, "name" => "Avaliados"];
        $projetosNaoCompareceu = ["projetos" => array(), "total" => 0, "name" => "Não Compareceu"];
        foreach ($projetos as $projeto) {
            switch ($projeto->situacao_id) {
                case EnumSituacaoProjeto::getValue("Cadastrado"):
                    array_push($projetosCadastrados["projetos"], $projeto);
                    $projetosCadastrados["total"] += 1;
                    break;
                case EnumSituacaoProjeto::getValue("NaoHomologado"):
                    array_push($projetosNaoHomologados["projetos"], $projeto);
                    $projetosNaoHomologados["total"] += 1;
                    break;
                case EnumSituacaoProjeto::getValue("Homologado"):
                    array_push($projetosHomologados["projetos"], $projeto);
                    $projetosHomologados["total"] += 1;
                    break;
                case EnumSituacaoProjeto::getValue("NaoAvaliado"):
                    array_push($projetosNaoAvaliados["projetos"], $projeto);
                    $projetosNaoAvaliados["total"] += 1;
                    break;
                case EnumSituacaoProjeto::getValue("Avaliado"):
                    array_push($projetosAvaliados["projetos"], $projeto);
                    $projetosAvaliados["total"] += 1;
                    break;
                case EnumSituacaoProjeto::getValue("NaoCompareceu"):
                    array_push($projetosNaoCompareceu["projetos"], $projeto);
                    $projetosNaoCompareceu["total"] += 1;
                    break;
            }
        }

        $situacoes = [];
        $situacoes["cadastrados"] = $projetosCadastrados;
        $situacoes["naoHomologados"] = $projetosNaoHomologados;
        $situacoes["homologados"] = $projetosHomologados;
        $situacoes["naoAvaliadados"] = $projetosNaoAvaliados;
        $situacoes["avaliados"] = $projetosAvaliados;
        $situacoes["naoCompareceu"] = $projetosNaoCompareceu;

        //return PDF::loadView('relatorios.projetos', ['projetos' => $projetos])->download('projetos.pdf');
        return view(
            'relatorios.projetos',
            ["situacoes" => $situacoes]
        );
    }

    public function areas($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        return PDF::loadView('relatorios.gerais.areas', ['areas' => $areas])
            ->setPaper('A4', 'landscape')
            ->download('areas.pdf');
    }

    public function edicoes()
    {
        $edicoes = Edicao::orderBy('ano')->get();

        return PDF::loadView('relatorios.gerais.edicoes', ['edicoes' => $edicoes])->download('edicoes.pdf');
    }

    public function funcoesUsuarios()
    {
        $usuarios = Pessoa::select('pessoa.id', 'pessoa.nome', 'pessoa.email')
            ->get();

        return PDF::loadView('relatorios.funcoesUsuarios', array('usuarios' => $usuarios))->download('funcoes.pdf');
    }

    public function escolaProjetos($id)
    {
        $escola = Escola::find($id);

        $projetos = DB::table('escola_funcao_pessoa_projeto')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('escola_funcao_pessoa_projeto.escola_id', 'projeto.id', 'projeto.titulo')
            ->where('escola_id', $id)
            ->where('escola_funcao_pessoa_projeto.edicao_id', Edicao::getEdicaoId())
            ->distinct('projeto.id')
            ->get()
            ->toArray();

        $numeroProjetos = count($projetos);

        return PDF::loadView('relatorios.escolaProjetos', array('escola' => $escola, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('escola_projetos.pdf');
    }

    public function nivelProjetos($id)
    {
        $nivel = Nivel::find($id);
        $projetos = Projeto::where('nivel_id', $id)->where('edicao_id', Edicao::getEdicaoId())->get();

        $numeroProjetos = count($projetos);

        return PDF::loadView('relatorios.nivelProjetos', array('nivel' => $nivel, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('nivelProjetos.pdf');
    }

    public function areaProjetos($id)
    {
        $area = AreaConhecimento::find($id);

        $projetos = Projeto::where('area_id', $id)->where('edicao_id', Edicao::getEdicaoId())->get();

        $numeroProjetos = count($projetos);

        return PDF::loadView('relatorios.areaProjetos', array('area' => $area, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('areaProjetos.pdf');
    }

    public function voluntarioTarefa($edicao)
    {

        $voluntarios = Pessoa::select('pessoa.id', 'pessoa.nome', 'pessoa.email', 'tarefa.tarefa')
            ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('funcao', 'funcao_pessoa.funcao_id', '=', 'funcao.id')
            ->join('pessoa_tarefa', 'pessoa.id', '=', 'pessoa_tarefa.pessoa_id')
            ->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
            ->where('funcao.funcao', 'Voluntário')
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('pessoa_tarefa.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->get();

        return PDF::loadView('relatorios.voluntarios.voluntarioTarefa', ['voluntarios' => $voluntarios])
            ->download('voluntarios_tarefas.pdf');
    }

    public function tarefaVoluntarios($id)
    {
        $tarefa = Tarefa::find($id);

        return PDF::loadView('relatorios.tarefaVoluntarios', array('tarefa' => $tarefa))->download('tarefaVoluntarios.pdf');
    }

    public function homologadoresArea($edicao)
    {

        $areas = DB::table('area_conhecimento')
            ->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
            ->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
            ->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
            ->where('area_edicao.edicao_id', '=', $edicao)
            ->orderBy('nivel.nivel')
            ->get()
            ->toArray();

        $homologadoresAreas = [];

        foreach ($areas as $area) {

            $homologadores = DB::table('pessoa')
                ->select('pessoa.nome', 'areas_comissao.area_id')
                ->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
                ->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
                ->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
                ->where('funcao_pessoa.funcao_id', '=', EnumFuncaoPessoa::getValue('Homologador'))
                ->where('funcao_pessoa.homologado', '=', true)
                ->where('funcao_pessoa.edicao_id', '=', $edicao)
                ->where('comissao_edicao.edicao_id', '=', $edicao)
                ->where('areas_comissao.area_id', '=', $area->id)
                ->orderBy('pessoa.nome')
                ->distinct()
                ->get()
                ->toArray();

            array_push($homologadoresAreas, [
                'area' => $area,
                'homologadores' => $homologadores,
            ]);
        }

        //return PDF::loadView('relatorios.homologacao.homologadoresArea', compact('homologadoresAreas'))->download('homologadores_area.pdf');
        return view('relatorios.homologacao.homologadoresArea', compact('homologadoresAreas'));
    }

    public function avaliadoresArea($edicao)
    {

        $areas = DB::table('area_conhecimento')
            ->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
            ->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
            ->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
            ->where('area_edicao.edicao_id', '=', $edicao)
            ->orderBy('nivel.nivel')
            ->get()
            ->toArray();

        foreach ($areas as $key => $area) {

            $areas[$key]->avaliadores = DB::table('pessoa')
                ->select('pessoa.nome', 'pessoa.id')
                ->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
                ->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
                ->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
                ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
                ->where('funcao_pessoa.edicao_id', '=', $edicao)
                ->where('funcao_pessoa.homologado', '=', true)
                ->where('areas_comissao.area_id', '=', $area->id)
                ->orderBy('pessoa.nome')
                ->distinct('pessoa.id')
                ->get()
                ->toArray();
        }

        //dd($areas);
        //return PDF::loadView('relatorios.avaliacao.avaliadoresArea', ['areas' => $areas])->download('avaliadores_area.pdf');
        return view('relatorios.avaliacao.avaliadoresArea', ['areas' => $areas]);
    }

    public function homologadoresProjeto($edicao)
    {
        $projetos = Projeto::select('projeto.id', 'projeto.titulo')
            ->where('projeto.edicao_id', $edicao)
            ->orderBy('projeto.titulo')
            ->get();

        //return PDF::loadView('relatorios.homologacao.homologadoresProjeto', ['projetos' => $projetos])->download('homologadores_projeto.pdf');
        return view('relatorios.homologacao.homologadoresProjeto', ['projetos' => $projetos]);
    }

    public function avaliadoresProjeto($edicao)
    {
        $projetos = Projeto::select('projeto.id', 'projeto.titulo')
            ->where('projeto.edicao_id', '=', $edicao)
            ->orderBy('projeto.titulo')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->get();

        /*
        return PDF::loadView(
        'relatorios.avaliacao.avaliadoresProjeto',
        ['projetos' => $projetos]
        )->download('avaliadores_projeto.pdf');
         */

        return view('relatorios.avaliacao.avaliadoresProjeto', ['projetos' => $projetos]);
    }

    public function projetosConfirmaramPresenca($edicao)
    {
        $projetos = DB::table('projeto')
            ->select('projeto.id', 'projeto.titulo')
            ->where('projeto.edicao_id', $edicao)
            ->where('projeto.presenca', true)
            ->orderBy('projeto.titulo')
            ->get()
            ->toArray();

        //return PDF::loadView('relatorios.projetosConfirmaramPresenca', array('projetos' => $projetos))->download('projetos_comparecerão.pdf');
        return view('relatorios.projetosConfirmaramPresenca', array('projetos' => $projetos));
    }

    public function classificacaoProjetos($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        /*
        return PDF::loadView('relatorios.premiacao.classificacaoProjetos', ['areas' => $areas, 'edicao' => $edicao])
            ->setPaper('A4', 'landscape')
            ->download('classificacao_projetos.pdf');
        */

        return view('relatorios.premiacao.classificacaoProjetos', ['areas' => $areas, 'edicao' => $edicao]);
    }

    public function premiacaoProjetos($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        /*
        return PDF::loadView('relatorios.premiacao.premiacaoProjetos', ['areas' => $areas, 'edicao' => $edicao])
            ->setPaper('A4', 'landscape')
            ->download('premiacao_projetos.pdf');
        */

        return view('relatorios.premiacao.premiacaoProjetos', ['areas' => $areas, 'edicao' => $edicao]);
    }

    public function classificacaoGeral($edicao)
    {
        $niveis = Edicao::find($edicao)->niveis;

        /*
        return PDF::loadView('relatorios.premiacao.classificacaoGeral', ['niveis' => $niveis, 'edicao' => $edicao])
            ->setPaper('A4', 'landscape')
            ->download('classificacao_geral.pdf');
        */
        return view('relatorios.premiacao.classificacaoGeral', ['niveis' => $niveis, 'edicao' => $edicao]);
    }

    public function statusProjetos($edicao)
    {
        $projetos = DB::table('projeto')
            ->select('projeto.id', 'projeto.titulo', 'situacao.situacao')
            ->join('situacao', 'projeto.situacao_id', '=', 'situacao.id')
            ->where('projeto.edicao_id', $edicao)
            ->orderBy('situacao.situacao')
            ->orderBy('projeto.titulo')
            ->get()
            ->toArray();

        //return PDF::loadView('relatorios.statusProjetos', ['projetos' => $projetos])
        //->download('status_projetos.pdf');
        return view('relatorios.statusProjetos', ['projetos' => $projetos]);
    }

    public function projetosCompareceram($edicao)
    {
        $projetos = DB::table('projeto')
            ->select('projeto.id', 'projeto.titulo')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
            ->join('presenca', 'pessoa.id', '=', 'presenca.id_pessoa')
            ->where('projeto.edicao_id', $edicao)
            ->orderBy('projeto.titulo')
            ->distinct('projeto.id')
            ->get()
            ->toArray();

        //return PDF::loadView('relatorios.projetosCompareceram', array('projetos' => $projetos, 'edicao' => $edicao))->download('projetos_compareceram.pdf');
        return view('relatorios.projetosCompareceram', array('projetos' => $projetos, 'edicao' => $edicao));
    }

    public function projetosCompareceramPorAutor($edicao)
    {
        $autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->where('escola_funcao_pessoa_projeto.funcao_id', EnumFuncaoPessoa::getValue('Autor'))
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Avaliado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('projeto.edicao_id', $edicao)
            ->orderBy('pessoa.nome')
            ->get();

        /*
        return PDF::loadView(
        'relatorios.projetosCompareceramPorAutor',
        [
        'autores' => $autores,
        'edicao' => $edicao,
        ]
        )->download('projetos_compareceram_autor.pdf');
         */
        return view(
            'relatorios.projetosCompareceramPorAutor',
            [
                'autores' => $autores,
                'edicao' => $edicao,
            ]
        );
    }

    public function projetosCompareceramIFRSCanoas($edicao)
    {

        $areas = Edicao::find($edicao)->areas;

        //return PDF::loadView('relatorios.projetosCompareceramIFRSCanoas', array('areas' => $areas, 'edicao' => $edicao))->setPaper('A4', 'landscape')->download('projetos_compareceram_ifrs_canoas.pdf');
        return view('relatorios.projetosCompareceramIFRSCanoas', array('areas' => $areas, 'edicao' => $edicao));
    }

    public function gerarLocalizacaoProjetos($edicao)
    {
        $niveis = DB::table('nivel_edicao')
            ->select('nivel.id', 'nivel', 'min_ch', 'max_ch', 'palavras')
            ->where('edicao_id', '=', $edicao)
            ->join('nivel', 'nivel_edicao.nivel_id', '=', 'nivel.id')
            ->get();

        return view('relatorios.projetos.gerarLocalizacaoProjetos', ['edicao' => $edicao])->withNiveis($niveis);
    }

    public function geraLocalizacaoProjetos(Request $req, $edicao)
    {
        $data = $req->all();
        $num = $data['button'];
        $ids = array();
        $cont = 0;

        foreach ($data['bloco'] as $key => $bloco) {
            $numeroSalas = ($data['ate'][$key] - $data['de'][$key]) + 1;
            $numeroProjetos = $data['num'][$key];

            for ($i = $data['de'][$key]; $i <= $data['ate'][$key]; $i++) {

                $projetos[$bloco][$i] = DB::table('projeto')
                    ->select('projeto.id', 'projeto.titulo', 'area_conhecimento.area_conhecimento', 'nivel.nivel', 'escola.nome_curto')
                    ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
                    ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
                    ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
                    ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
                    ->where('projeto.edicao_id', $edicao)
                    ->whereIn(
                        'projeto.situacao_id',
                        [
                            EnumSituacaoProjeto::getValue('Homologado'),
                            EnumSituacaoProjeto::getValue('NaoAvaliado'),
                            EnumSituacaoProjeto::getValue('Avaliado'),
                        ]
                    )
                    ->where('projeto.presenca', true)
                    ->where('nivel.id', $data['nivel'][$key])
                    ->whereNotIn('projeto.id', $ids)
                    ->distinct('projeto.id')
                    ->orderBy('area_conhecimento.area_conhecimento')
                    ->orderBy('nivel.nivel')
                    ->orderBy('projeto.titulo')
                    ->limit($numeroProjetos)
                    ->get()
                    ->toArray();

                $ids = array_merge($ids, array_column($projetos[$bloco][$i], 'id'));
            }
        }

        $cont = 1;
        if ($num == 1) {
            return PDF::loadView('relatorios.geraLocalizacaoProjetos', array('projetos' => $projetos, 'cont' => $cont))->setPaper('A4', 'landscape')->download('projetos_identificacao.pdf');
            //return view('relatorios.geraLocalizacaoProjetos', array('projetos' => $projetos, 'cont' => $cont));
        }
        if ($num == 2) {
            //return PDF::loadView('relatorios.identificacaoProjetos', array('projetos' => $projetos, 'cont' => $cont))->setPaper('A4', 'landscape')->download('projetos_localizacao.pdf');
            return view('relatorios.identificacaoProjetos', array('projetos' => $projetos, 'cont' => $cont));
        }
    }

    public function gerarValeLanche($edicao)
    {
        return view('admin.gerarValeLanche', ['edicao' => $edicao]);
    }

    public function valeLanche(Request $req, $edicao)
    {
        $data = $req->all();
        $dias = $data['dias'];

        $numAutores = DB::table('funcao_pessoa')
            ->select('pessoa.id')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('funcao_pessoa.edicao_id', '=', $edicao)
            ->where('projeto.presenca', '=', true)
            ->where('escola.nome_curto', '!=', 'IFRS Canoas')
            ->where('funcao_pessoa.funcao_id', '=', EnumFuncaoPessoa::getValue('Autor'))
            ->distinct('pessoa.id')
            ->count();

        $cont = $numAutores * $dias;

        return view('relatorios.lanche.valeLanche', ['cont' => $cont]);
    }

    public function projetosConfirmaramPresencaArea($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        /*
        return PDF::loadView(
        'relatorios.projetosConfirmaramPresencaArea',
        [
        'areas' => $areas,
        'edicao' => $edicao,
        ]
        )->download('projetos_presenca_nivel.pdf');
         */
        return view(
            'relatorios.projetosConfirmaramPresencaArea',
            [
                'areas' => $areas,
                'edicao' => $edicao,
            ]
        );
    }

    public function premiacaoCertificados($edicao)
    {
        $areas = Edicao::find($edicao)->areas;

        $subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id', '=', DB::raw('projeto.id'))
            ->toSql();

        $projetos = Projeto::select(DB::raw('(' . $subQuery . ') as nota'), 'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id', 'escola.nome_curto', 'projeto.id', 'area_conhecimento.area_conhecimento')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id', '=', $edicao)
            ->where('projeto.situacao_id', '=', EnumSituacaoProjeto::getValue('Avaliado'))
            ->where('projeto.nota_avaliacao', '<>', null)
            ->groupBy('projeto.id')
            ->groupBy('area_conhecimento.area_conhecimento')
            ->groupBy('escola.nome_curto')
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();

        $data = Edicao::select('feira_fechamento')
            ->where('id', $edicao)->get();

        $data = date('d/m/Y', strtotime($data->first()->feira_fechamento));

        return PDF::loadView(
            'relatorios.premiacao.premiacaoCertificados',
            [
                'areas' => $areas,
                'projetos' => $projetos,
                'data' => $data,
                'edicao' => $edicao,
            ]
        )
            ->setPaper('A4', 'landscape')
            ->download('premiacao_certificados.pdf');
    }

    public function csvEmailNomeEscolas()
    {
        $filename = "RelatorioEscolaNomeEmail.csv";

        $escolas = DB::table('escola')->get();

        $handle = fopen($filename, 'w+');

        fputcsv($handle, array('Escola', 'Email'), ';');

        foreach ($escolas as $escola) {
            fputcsv($handle, array($escola->nome_curto, $escola->email), ';');
        }

        fclose($handle);
        $headers = ['Content-Type' => 'text/csv'];

        return Response::download($filename, $filename, $headers);
    }

    public function csvMailing()
    {
        $usuariosComMailing = DB::table('pessoa')
            ->where('newsletter', true)
            ->select('nome', 'email')
            ->get();

        $fileRows = [];
        foreach ($usuariosComMailing as $row) {
            $rowData = [
                utf8_decode($row->nome),
                utf8_decode($row->email),
            ];

            array_push($fileRows, $rowData);
        }

        $headerFields = ['Nome', 'Email'];

        return $this->returnsCSVStream('MailingUsuarios.csv', $headerFields, $fileRows);
    }

    public function csvMailingOrientadoresPosHomologacao($edicao)
    {
        $orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.email')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $filename = "csvOrientadoresPosHomologacao.csv";
        $fileHeaders = [
            "Nome",
            "Email",
        ];

        $fileRows = [];
        foreach ($orientadores as $row) {
            $rowData = [
                utf8_decode($row->nome),
                utf8_decode($row->email),
            ];

            array_push($fileRows, $rowData);
        }

        return $this->returnsCSVStream($filename, $fileHeaders, $fileRows);
    }

    public function csvMailingCoorientadoresPosHomologacao($edicao)
    {
        $coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.email')
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('projeto.presenca', true)
            ->where('funcao_pessoa.edicao_id', $edicao)
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
            ->orderBy('pessoa.nome')
            ->distinct('pessoa.id')
            ->get();

        $filename = "csvCoorientadoresPosHomologacao.csv";
        $fileHeaders = [
            "Nome",
            "Email",
        ];

        $fileRows = [];
        foreach ($coorientadores as $row) {
            $rowData = [
                utf8_decode($row->nome),
                utf8_decode($row->email),
            ];

            array_push($fileRows, $rowData);
        }

        return $this->returnsCSVStream($filename, $fileHeaders, $fileRows);
    }

    public function csvIdentificacaoMontagem($edicao)
    {
        $projetos = DB::table('projeto')
            ->select('projeto.id', 'projeto.titulo', 'area_conhecimento.area_conhecimento', 'nivel.nivel', 'escola.nome_curto')
            ->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
            ->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
            ->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
            ->where('projeto.edicao_id', $edicao)
            ->whereIn(
                'projeto.situacao_id',
                [
                    EnumSituacaoProjeto::getValue('Homologado'),
                    EnumSituacaoProjeto::getValue('NaoAvaliado'),
                    EnumSituacaoProjeto::getValue('Avaliado'),
                ]
            )
            ->where('projeto.presenca', true)
            ->distinct('projeto.id')
            ->orderBy('area_conhecimento.area_conhecimento')
            ->orderBy('nivel.nivel')
            ->orderBy('projeto.titulo')
            ->get()
            ->toArray();

        $filename = "csvIdentificacaoMontagem.csv";
        $fileheaders = [
            "NomeProj",
            "EscolaCurta",
            "Area",
            "Nivel",
        ];


        $fileRows = [];
        foreach ($projetos as $row) {
            $rowData = [
                utf8_decode($row->titulo),
                utf8_decode($row->nome_curto),
                utf8_decode($row->area_conhecimento),
                utf8_decode($row->nivel),
            ];

            array_push($fileRows, $rowData);
        }

        return $this->returnsCSVStream($filename, $fileheaders, $fileRows);
    }

    public function csvEscolaPorTipo()
    {
        $escolas = Escola::getAllByTipo();

        $filename = "csvEscolaPorTipo.csv";
        $fileheaders = [
            "Nome Completo",
            "Tipo"
        ];

        $filerows = [];
        foreach ($escolas as $escola) {
            $rowdata = [
                utf8_decode($escola->nome_completo),
                $escola->publica == true ? "Publica" : "Privada",
            ];

            array_push($filerows, $rowdata);
        }

        return $this->returnsCSVStream($filename, $fileheaders, $filerows);
    }

    public function escolaPorTipo()
    {
        $escolas = Escola::getAllByTipo();

        $escolasPublicas = [];
        $escolasPrivadas = [];
        foreach ($escolas as $escola) {
            if ($escola->publica) {
                array_push($escolasPublicas, $escola);
            } else {
                array_push($escolasPrivadas, $escola);
            }
        }

        return view('relatorios.gerais.escolasPorTipo', ['escolasPublicas' => $escolasPublicas, 'escolasPrivadas' => $escolasPrivadas]);
    }

    public function csvPresencaParticipantes($edicaoId)
    {
        $participantes = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo', 'escola_funcao_pessoa_projeto.funcao_id')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->where('projeto.nota_avaliacao', '<>', 0) // presença dada pela nota de avaliação diferente de zero
            ->where('funcao_pessoa.edicao_id', '=', $edicaoId)
            ->where('projeto.edicao_id', '=', $edicaoId)
            ->orderBy('pessoa.nome')
            ->get();

        $subQueryHomolog = DB::raw('SELECT count(*)
			FROM revisao
			WHERE revisao.pessoa_id = pessoa.id AND
				revisao.projeto_id = projeto.id');

        $homologadores = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo', 'funcao_pessoa.funcao_id')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('revisao', 'pessoa.id', '=', 'revisao.pessoa_id')
            ->join('projeto', 'revisao.projeto_id', '=', 'projeto.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Homologador'))
            ->where('funcao_pessoa.edicao_id', $edicaoId)
            ->where('projeto.edicao_id', '=', $edicaoId)
            ->where(DB::raw('(' . $subQueryHomolog . ')'), '>', 0)
            ->orderBy('pessoa.nome')
            ->get();

        $subQueryAval = DB::raw('SELECT count(*)
			FROM presenca
			WHERE presenca.id_pessoa = pessoa.id AND
				projeto.edicao_id = presenca.edicao_id');

        $avaliadores = DB::table('funcao_pessoa')
            ->select('pessoa.nome', 'pessoa.cpf', 'pessoa.email', 'projeto.titulo', 'funcao_pessoa.funcao_id')
            ->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
            ->join('avaliacao', 'pessoa.id', '=', 'avaliacao.pessoa_id')
            ->join('projeto', 'avaliacao.projeto_id', '=', 'projeto.id')
            ->where('funcao_pessoa.funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
            ->where('funcao_pessoa.edicao_id', '=', $edicaoId)
            ->where('projeto.edicao_id', '=', $edicaoId)
            ->where(DB::raw('(' . $subQueryAval . ')'), '>', 0)
            ->orderBy('pessoa.nome')
            ->get();

        $filename = "csvPresencaParticipantes.csv";
        $headerFields = [
            'NOME_PARTICIPANTE',
            'EMAIL_PARTICIPANTE',
            'CPF_PARTICIPANTE',
            'PROJETO_PARTICIPANTE',
            'FUNCAO_PARTICIPANTE'
        ];

        $rows = [];
        foreach ($participantes as $participante) {
            array_push($rows, [
                utf8_decode($participante->nome),
                utf8_decode($participante->email),
                $participante->cpf,
                utf8_decode($participante->titulo),
                utf8_decode(EnumFuncaoPessoa::getKey($participante->funcao_id))
            ]);
        }
        foreach ($avaliadores as $avaliador) {
            array_push($rows, [
                utf8_decode($avaliador->nome),
                utf8_decode($avaliador->email),
                $avaliador->cpf,
                utf8_decode($avaliador->titulo),
                utf8_decode(EnumFuncaoPessoa::getKey($avaliador->funcao_id))
            ]);
        }
        foreach ($homologadores as $homologador) {
            array_push($rows, [
                utf8_decode($homologador->nome),
                utf8_decode($homologador->email),
                $homologador->cpf,
                utf8_decode($homologador->titulo),
                utf8_decode(EnumFuncaoPessoa::getKey($homologador->funcao_id))
            ]);
        }

        return $this->returnsCSVStream($filename, $headerFields, $rows);
    }

    public function alunosConcluintesPorProjeto($edicao)
    {
        $concluintes = DB::table('escola_funcao_pessoa_projeto')
            ->join('pessoa', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
            ->join('projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->where('escola_funcao_pessoa_projeto.concluinte', '=', true)
            ->where('escola_funcao_pessoa_projeto.edicao_id', '=', $edicao)
            ->select('projeto.id', 'pessoa.nome', 'pessoa.email')
            ->get();

        $projetos = DB::table('escola_funcao_pessoa_projeto')
            ->join('projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
            ->where('escola_funcao_pessoa_projeto.concluinte', '=', true)
            ->where('escola_funcao_pessoa_projeto.edicao_id', '=', $edicao)
            ->distinct()
            ->select('projeto.id', 'projeto.titulo')
            ->get();

        $dados = [];

        foreach ($projetos as $key => $projeto) {
            $concluintesFiltrados = [];
            foreach ($concluintes as $key => $concluinte) {
                if ($projeto->id == $concluinte->id) {
                    array_push($concluintesFiltrados, $concluinte);
                }
            }
            array_push($dados, ['projeto' => $projeto->titulo, 'concluintes' => $concluintesFiltrados]);
        }

        return view('relatorios.projetos.concluintesProjeto', ['dados' => $dados]);
    }
}
