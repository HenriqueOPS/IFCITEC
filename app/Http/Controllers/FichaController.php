<?php

namespace App\Http\Controllers;

use App\Campo;
use App\Categoria;
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
            'categoria_avaliacao' => $data['categoria_avaliacao'],
        ]);

        return redirect()->route('cadastroCategoria');

    }

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
            Campo::create([
                'edicao_id' => $data ['edicao_id'],
                'tipo' => $data['tipo'],
                'categoria_id' => $data['categoria_id'],
                'campo' => $data['campo'][$i],
                'val_0' => $data['val_0'][$i],
                'val_25' => $data['val_25'][$i],
                'val_50' => $data['val_50'][$i],
                'val_75' => $data['val_75'][$i],
                'val_100' => $data['val_100'][$i],
            ]);
        }
        return redirect()->route('cadastroCampo');
    }
public function categoria(){
        return view('admin.ficha');
    }

    //Lista Categoria
    public function mostraCateg(){
        $cat= Categoria::orderBy('categoria_avaliacao')
            ->get();
        return view('admin.mostraCategoria', collect(['cat' => $cat]));
    }

    public function dadosCategoria($id)
    { //Ajax

        //dd(Campo::select()->getCamposCategoria());
//DB::enableQueryLog();
        $categoria = Categoria::find($id)
            ->join('nivel', 'nivel_id','=','nivel.id')
            ->select('nivel','categoria_avaliacao','peso')
            ->get()
        ;

//print_r(DB::getQueryLog());
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

    //Lista Itens

    public function mostraItem(){
        $it= Campo::orderBy('campo')->get();
        return view('admin.mostraItem', collect(['it' => $it]));
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



}