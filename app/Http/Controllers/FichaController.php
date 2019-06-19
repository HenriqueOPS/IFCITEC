<?php

namespace App\Http\Controllers;

use App\Campo;
use App\Categoria;
use App\Edicao;
use App\Nivel;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\categoriaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichaController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }
//Categoria
    public function cadastroCategoria()
    {
        $edicoes = DB::table('edicao')->select('id')->get();
        $nomeN = DB::table('nivel')->select('*')->get();

        //dd($niveis);OK
        return view('fichas.cadastroCategoria', ['edicoes' => $edicoes], ['nomeN' => $nomeN]);
    }


    public function cadastraCategoria(Request $req)// com categoriaRequest nao funciona
{
    $data = $req->all();

    Categoria::create([
        'peso' => $data['peso_categoria'],
        'nivel_id' => $data['nivel_id'],
        'edicao_id' => $data['edicao_id'],
        'descricao' => $data['descricao'],
    ]);
//    dd($data);

    return redirect()->route('cadastroCategoria');

}

    public function categoria(){
        return view('fichas.ficha');
    }

    //Mostra Categoria (usado em categoria)
    public function mostraCateg(){
        $cat= Categoria::orderBy('descricao')
            ->get();
        return view('fichas.Categoria', collect(['cat' => $cat]));
    }

    //Lista Categoria(usado em criterio)
    public function listaCategoria(){
        $cat= Categoria::orderBy('descricao')
            ->get();
        return view('fichas.criterio', collect(['cat' => $cat]));
    }


    public function dadosCategoria($id)
    { //Ajax
        $categoria = Categoria::find($id)
            ->join('nivel', 'nivel_id','=','nivel.id')
            ->join('edicao','edicao_id','=','edicao.id')
            ->select('nivel','categoria_avaliacao.descricao','peso', 'edicao.ano')
            ->get();
        $campos = Campo::select()
            ->where('categoria_id', '=', $id)
            ->get();
        $response = [
            'campos' => $campos,
            'categoria' => $categoria[0]
        ];
        return response()->json($response);
    }

    public function excluiCategoria($id, $s)
    {

        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            Categoria::find($id)->delete();
            return 'true';
        } else {
            return 'password-problem';
        }
    }

    //Edita Categoria
    //*Coloca dados já cadastrados*
    public function editarCategoria($id)
    {
        $edicao= DB::table('edicao')->select('id', 'ano')->get();
        $niveis = DB::table('nivel')->select('id', 'nivel')->get();
        $dados = Categoria::find($id);


        return view('fichas.editCat', compact('niveis', 'edicao', 'dados', 'n'));
    }

    public function editaCategoria(Request $req)
    {
        $data = $req->all();
        $id = $data['id_categoria'];

        Categoria::where('id', $id)
            ->update([ 'peso' => $data['peso'],
            'nivel_id' => $data['nivel_id'],
            'edicao_id'=> $data['edicao_id'],
            'descricao' => $data['categoria_avaliacao']
            ]);

        return redirect()->route('mostraCat');
    }



//Campos
    public function cadastroCampo()
    {

        $edicoes = DB::table('edicao')->select('id')->get();
        $categorias = DB::table('categoria_avaliacao')->select('*')->get();

        return view('fichas.cadastroItem', ['edicoes' => $edicoes], ['categorias' => $categorias]);
    }

    public function cadastrarCampo(Request $req) //precisa do campoRequest?
    {
        $data = $req->all();
        //cadastra mais de uma linha
        for ($i = 0; $i < count($data['campo']); $i++) {

            $fields = [
                'edicao_id' => $data ['edicao_id'],
                'tipo' => $data['tipo'],
                'categoria_id' => $data['categoria_id'],
                'campo' => $data['campo'][$i]
            ];

            $fields['val_0'] = $data['val_0'][$i] ?? false;
            $fields['val_25'] = $data['val_25'][$i] ?? false;
            $fields['val_50'] = $data['val_50'][$i] ?? false;
            $fields['val_75'] = $data['val_75'][$i] ?? false;
            $fields['val_100'] = $data['val_100'][$i] ?? false;

            Campo::create($fields);
        }
//        dd($data);
        return redirect()->route('cadastroCampo');
    }

    public function excluiItem($id, $s)
    {

        if (password_verify($s, Auth::user()['attributes']['senha'])) {
            Campo::find($id)->delete();
            return 'true';
        } else {
            return 'password-problem';
        }
    }

//    //Lista Itens
//    public function mostraItem(){
//        $it= Campo::orderBy('campo')->get();
//        return view('fichas.mostraItem', collect(['it' => $it]));
//    }






}