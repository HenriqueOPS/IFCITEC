<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable as Notifiable;
//
use Illuminate\Support\Facades\DB;

class Pessoa extends Authenticatable {

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
        'camisa', 'lattes', 'telefone',

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

    public function getAuthPassword() { //Para sistema poder fazer login via atributo "password"
        return $this->senha;
    }

    public function getTable() {
        $schema = isset($this->schema) ? $this->schema : env('DB_SCHEMA');
        return $schema . '.' . $this->table;
    }

    public function edicoes() {
        return $this->belongsToMany('App\Edicao', 'comissao_edicao','pessoa_id','edicao_id');
    }

    public function tarefas() {
        return $this->belongsToMany('App\Tarefa');
    }

	/**
	 * Verifica se pessoa possui a função passada por parâmetro
	 * na edição corrente
	 * @access public
	 * @param String $check Uma string contento o nome da Role
	 * @return boolean
	 */
	public function temFuncao($funcao) {

    	//pega o id da edição
		$EdicaoId = Edicao::getEdicaoId();

		if($EdicaoId){

			//Faz a consulta na mão por causa dos Wheres
			$query = DB::table('funcao_pessoa')
							->join('funcao','funcao.id','=','funcao_pessoa.funcao_id')
							//Busca pela Função
							->where('funcao.funcao','=',$funcao)
							//Busca pela Pessoa
							->where('funcao_pessoa.pessoa_id','=',$this->id)
							//Busca pela Edição
							->where('edicao_id', $EdicaoId)
							->orWhere('edicao_id',null)
							->get();

			if($query->count()) {
				//Verifica se não foi homologado como Revisor ou Avaliador
				if(($funcao=='Revisor' || $funcao=='Avaliador') && !$query[0]->homologado)
					return false;

				return true;
			}
		}

		return false;
	}

    public function funcoes() {
        return $this->belongsToMany('App\Funcao');
    }

    public function projetos() {
        return $this->belongsToMany('App\Projeto', 'escola_funcao_pessoa_projeto')->withPivot('escola_id', 'funcao_id');
    }

    public function avaliacoes() {
        return $this->hasMany('App\Avaliacao');
    }

    public function revisoes() {
        return $this->hasMany('App\Revisao');
    }

    static function findByEmail($email) {
        return Pessoa::where('email', $email)->first();
    }

    public function scopeWhereFuncao($query, $funcao){
        return $query
            ->join('funcao_pessoa','funcao_pessoa.pessoa_id','=','public.pessoa.id')
            ->join('funcao','funcao.id','=','funcao_pessoa.funcao_id')
            ->where('funcao.funcao','=',$funcao);
    }

    public function getTotalRevisoes(){
        $total = DB::table('revisao')
            ->select(DB::raw('count(*) as total'))
            ->join('public.pessoa','revisao.pessoa_id','=','public.pessoa.id')
            ->where('public.pessoa.id','=',$this->id)
            ->first();

        return $total->total;
    }

    public function getTotalAvaliacoes(){
        $total = DB::table('avaliacao')
            ->select(DB::raw('count(*) as total'))
            ->join('public.pessoa','avaliacao.pessoa_id','=','public.pessoa.id')
            ->where('public.pessoa.id','=',$this->id)
            ->first();

        return $total->total;
    }

}
