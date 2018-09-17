<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pessoa;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;


class PessoaController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Display the specified Pessoa searching by email.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function showByEmail($email) {
        //
        $pessoa = Pessoa::findByEmail($email);
        if (!($pessoa instanceof Pessoa)) {
            return response()->json("A pessoa não está inscrita no sistema!", 204);
        }

        return response()->json($pessoa, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function relatorio(){
        if(Auth::user()->temFuncao('Organizador')) {
            $usuarios = \Illuminate\Support\Facades\DB::table('public.pessoa')
                ->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
                ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->groupBy('pessoa.id', 'pessoa.nome', 'pessoa.email')
                ->havingRaw('count(pessoa.id) = 1')
                ->get();

            $avaliadores = \Illuminate\Support\Facades\DB::table('public.pessoa')
                ->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
                ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->where('funcao_id', '=', '3')
                ->get();

            $revisores = \Illuminate\Support\Facades\DB::table('public.pessoa')
                ->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
                ->join('funcao_pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
                ->where('funcao_id', '=', '4')
                ->get();

            $pdf = PDF:: loadView('organizacao.relatorio', ['usuarios' => $usuarios, 'avaliadores' => $avaliadores, 'revisores' => $revisores]);
            return $pdf->download('relatorio_pessoas.pdf');
        }else{
            return redirect('home');
        }
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        if (session()->has('email')) {
            $data = $this->setSessionValues($data);
        }

        return Validator::make($data, [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pgsql.pessoa',
            'senha' => 'required|string|confirmed',
            'dt_nascimento' => 'required|date_format:d/m/Y|before:today|after:01/01/1900',
            'rg' => 'required|string|unique:pgsql.pessoa',
            'telefone' => 'string|min:8|max:15',
            'cpf' => 'string|unique:pgsql.pessoa|min:11|max:14',
            'confirmacaoRg' => 'required'
        ]);
    }
    
    public function editarCadastro() {
        $dados = Pessoa::find(Auth::user()->id);
        $dados->dt_nascimento = implode("/", array_reverse(explode("-", $dados->dt_nascimento)));
        
        return view('user.edit', compact('dados'));
    }

    public function editaCadastro(Request $req) {
        $data = $req->all();
        $data['dt_nascimento'] = implode('-',array_reverse(explode('/', $data['dt_nascimento'])));
        Pessoa::find(Auth::user()->id)->update($data);
        return redirect()->route('editarCadastro');
    }

    // Edita os dados do usuário (SOMENTE PARA ADMINISTRADOR)
    public function editarUsuario($id) {
        $dados = Pessoa::find($id);
        $dados->dt_nascimento = implode("/", array_reverse(explode("-", $dados->dt_nascimento)));
        return view('admin.usuario.editarCadastro', compact('dados'));
    }

    public function editaUsuario(Request $req, $id) {
        $data = $req->all();
        $data['dt_nascimento'] = implode('-',array_reverse(explode('/', $data['dt_nascimento'])));
        Pessoa::find($id)->update($data);
        return redirect()->route('administrador.usuarios');

    }


}
