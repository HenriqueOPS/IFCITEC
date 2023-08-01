<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Media;
class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function background(Request $request)
    {
        $nome = $request->input('imagem');
        $requestImage = $request->file('image');
        $conteudo = base64_encode(file_get_contents($requestImage));
    
        // Verificar se a imagem já existe pelo nome
        $media = Media::where('nome', $nome)->first();
    
        if ($media) {
            // Atualizar a imagem existente
            $media->conteudo = $conteudo;
            $media->save();
        } else {
            // Criar uma nova imagem
            $media = Media::create([
                'conteudo' => $conteudo,
                'nome' => $nome,
            ]);
        }
        if($nome=='Imagem'){
            $directory = public_path('img');
            $requestImage->move($directory, $nome .'.png');
        }
        return redirect()->route('admin.configuracoes');
    }
}
