<?php

namespace App\Http\Controllers;

use App\Pessoa;
use Illuminate\Http\Request;
use QRCode;

class CrachaController extends Controller
{

	public function generateQrCode($idPessoa){
		return QRCode::text($idPessoa)->svg();
	}

	public function generateCrachas(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));
	}

}
