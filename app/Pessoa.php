<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable as Notifiable;
//
use Illuminate\Support\Facades\DB;

use App\Enums\EnumSituacaoProjeto;

class Pessoa extends Authenticatable
{

    use Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pessoa';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $schema = 'public';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'email', 'senha', 'cpf', 'rg', 'dt_nascimento',
        'camisa', 'lattes', 'telefone', 'newsletter', 'oculto', 'verificado','genero','cor',
        'ehconcluinte',

        //Referentes a comição Avaliadora, necessário um estudo mais aprofundado
        //desta característica no sistema issue #40
        'titulacao', 'lattes', 'profissao', 'instituicao',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha', 'remember_token',
    ];

    public function getAuthPassword()
    { //Para sistema poder fazer login via atributo "password"
        return $this->senha;
    }

    public function getTable()
    {
        $schema = isset($this->schema) ? $this->schema : env('DB_SCHEMA');
        return $schema . '.' . $this->table;
    }

    public function edicoes()
    {
        return $this->belongsToMany('App\Edicao', 'comissao_edicao', 'pessoa_id', 'edicao_id');
    }

    public function tarefas()
    {
        return $this->belongsToMany('App\Tarefa', 'pessoa_tarefa', 'pessoa_id', 'tarefa_id');
    }

    /**
     * Verifica se pessoa possui a função passada por parâmetro
     * na edição corrente
     * @access public
     * @param String $check Uma string contento o nome da Role
     * @return boolean
     */
    public function temFuncao($funcao, $flag = false)
    {

        //pega o id da edição
        $edicaoId = Edicao::getEdicaoId();

        if ($edicaoId || $funcao == 'Administrador') {

            //Busca pela edição
            if ($edicaoId) {
                //Permissão apenas para a edição corrente ou para todas as edições
                //quando a pessoa possuir permissão para a edição de id 1, tbm terá para todas as demais

                //Faz a consulta na mão para a edição atual
                $query = DB::table('funcao_pessoa')
                    ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                    //Busca pela Função
                    ->where('funcao.funcao', '=', $funcao)
                    //Busca pela Pessoa
                    ->where('funcao_pessoa.pessoa_id', '=', $this->id)
                    ->where('funcao_pessoa.edicao_id', '=', $edicaoId);

                if (!$query->count()) { //Todas edições
                    $query = DB::table('funcao_pessoa')
                        ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                        //Busca pela Função
                        ->where('funcao.funcao', '=', $funcao)
                        //Busca pela Pessoa
                        ->where('funcao_pessoa.pessoa_id', '=', $this->id)
                        ->where('funcao_pessoa.edicao_id', '=', 1);
                }
            } else {
                //Permissão para todas as edições
                $query = DB::table('funcao_pessoa')
                    ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                    //Busca pela Função
                    ->where('funcao.funcao', '=', $funcao)
                    //Busca pela Pessoa
                    ->where('funcao_pessoa.pessoa_id', '=', $this->id)
                    ->where('funcao_pessoa.edicao_id', '=', 1);
            }

            if ($query->count()) {
                // Verifica se não foi homologado como Homologador ou Avaliador
                if ($funcao == 'Homologador' || $funcao == 'Avaliador') {
                    if (!$query->get()[0]->homologado && !$flag) {
                        return false;
                    }
                }

                return true;
            }
        }

        return false;
    }

    public function temFuncaoComissaoAvaliadora($funcao)
    {

        //pega o id da edição
        $EdicaoId = Edicao::getEdicaoId();

        if ($EdicaoId) {

            $query = DB::table('funcao_pessoa')
                ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
                //Busca pela Função
                ->where('funcao.funcao', '=', $funcao)
                //Busca pela Pessoa
                ->where('funcao_pessoa.pessoa_id', '=', $this->id)
                ->where('funcao_pessoa.homologado', '=', true);

            //Busca pela edição
            if ($EdicaoId) {
                //Permissão apenas para a edição corrente ou para todas as edições
                $query->where('edicao_id', $EdicaoId)
                    ->orWhere('edicao_id', null);
            } else {
                //Permissão apenas para todas as edições
                $query->where('edicao_id', null);
            }

            if ($query->count()) {
                return true;
            }
        }

        return false;
    }

    public function naoTemFuncao($funcao, $projeto, $pessoa)
    {

        //pega o id da edição
        $EdicaoId = Edicao::getEdicaoId();

        if ($EdicaoId) {

            $query = DB::table('escola_funcao_pessoa_projeto')
                //Busca pela Função
                ->where('funcao_id', '=', $funcao)
                //Busca pela Pessoa
                ->where('pessoa_id', '=', $pessoa)
                //Busca pelo Projeto
                ->where('projeto_id', '!=', $projeto)
                //Busca pela Edição
                ->where('edicao_id', $EdicaoId)
                ->orWhere('edicao_id', null)
                ->get();

            if (!$query->count()) {
                return true;
            }
        }

        return false;
    }

    public function temFuncaoProjeto($funcao, $projeto, $pessoa, $edicao)
    {
        if ($edicao) {
            $query = DB::table('escola_funcao_pessoa_projeto')
                // Busca pela Função
                ->where('funcao_id', '=', Funcao::where('funcao', $funcao)->get()->first()->id)
                // Busca pela Pessoa
                ->where('pessoa_id', $pessoa)
                // Busca pelo Projeto
                ->where('projeto_id', $projeto)
                // Busca pela Edição
                ->where('edicao_id', $edicao)
                ->get();

            if ($query->count())
                return true;
        }

        return false;
    }

    public function comissaoArea($area, $pessoa)
    {

        //pega o id da edição
        $EdicaoId = Edicao::getEdicaoId();

        if ($EdicaoId) {

            $query = DB::table('areas_comissao')
                ->join('area_conhecimento', 'areas_comissao.area_id', '=', 'area_conhecimento.id')
                ->join('comissao_edicao', 'areas_comissao.comissao_edicao_id', '=', 'comissao_edicao.id')
                //Busca pela Pessoa
                ->where('comissao_edicao.pessoa_id', '=', $pessoa)
                //Busca pelo Nível
                ->where('area_conhecimento.id', '=', $area)
                //Busca pela Edição
                ->where('comissao_edicao.edicao_id', $EdicaoId)
                ->orWhere('edicao_id', null)
                ->get();

            if (!$query->count())
                return true;
        }

        return false;
    }

    public function funcoes()
    {
        return $this->belongsToMany('App\Funcao', 'funcao_pessoa', 'pessoa_id', 'funcao_id');
    }

    public function projetos()
    {
        return $this->belongsToMany('App\Projeto', 'escola_funcao_pessoa_projeto')->withPivot('escola_id', 'funcao_id');
    }

    public function avaliacoes()
    {
        return $this->hasMany('App\Avaliacao', 'pessoa_id', 'id');
    }

    public function revisoes()
    {
        return $this->hasMany('App\Revisao', 'pessoa_id', 'id');
    }

    static function findByEmail($email)
    {
        return Pessoa::where('email', $email)->first();
    }

    public function scopeWhereFuncao($query, $funcao)
    {
        return $query
            ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'public.pessoa.id')
            ->join('funcao', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
            //busca pela Função
            ->where('funcao.funcao', '=', $funcao)
            //busca pela Edição
            ->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId());
    }

   

    public function getTotalAvaliacoes()
    {
        $total = DB::table('avaliacao')
            ->select(DB::raw('count(*) as total'))
            ->join('public.pessoa', 'avaliacao.pessoa_id', '=', 'public.pessoa.id')
            ->where('public.pessoa.id', '=', $this->id)
            ->first();

        return $total->total;
    }

    public function temTrabalho()
    {
        $total = DB::table('escola_funcao_pessoa_projeto')
            ->select('escola_funcao_pessoa_projeto.projeto_id', 'projeto.situacao_id')
            ->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
            ->where('escola_funcao_pessoa_projeto.pessoa_id', '=', $this->id)
            ->where('projeto.situacao_id', '<>', EnumSituacaoProjeto::getValue('NaoHomologado'))
            ->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
            ->get();

        if ($total->count())
            return true;

        return false;
    }

    public function temTarefa()
    {
        $total = DB::table('pessoa_tarefa')
            ->select('tarefa.tarefa')
            ->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
            ->where('pessoa_tarefa.pessoa_id', '=', $this->id)
            ->get();

        if ($total->count())
            return true;

        return false;
    }

    public function getProjetosAvaliador($id, $edicao)
    {
        $projetos = Projeto::select('projeto.id', 'titulo')
            ->join('avaliacao', 'projeto.id', '=', 'avaliacao.projeto_id')
            ->where('projeto.edicao_id', '=', $edicao)
            ->where('avaliacao.pessoa_id', '=', $id)
            ->orderBy('projeto.titulo', 'asc')
            ->get();

        return $projetos;
    }
    public function EcontroladorDePresenca(){
        $idfuncao = DB::table('tarefa')
        ->select('id')
        ->where('id', 17)
        ->first();
        $status = DB::table('pessoa_tarefa')
        ->where('pessoa_id',$this->id)
        ->where('tarefa_id',$idfuncao->id)
        ->where('edicao_id',Edicao::getEdicaoId())
        ->first();

        $dataFeira = DB::table('edicao')
        ->where('id',Edicao::getEdicaoId())
        ->select('avaliacao_abertura','avaliacao_fechamento')
        ->first();

        $dataAbertura = $dataFeira->avaliacao_abertura;
        $dataAbertura = strtotime($dataAbertura);

        $dataFechamento = $dataFeira->avaliacao_fechamento;
        $dataFechamento = strtotime($dataFechamento);

        $dataAtualTimestamp = strtotime(date('d-m-Y')); 
        if($status != null  ){
            return true;
        }else{
        return false;}
    }
}
