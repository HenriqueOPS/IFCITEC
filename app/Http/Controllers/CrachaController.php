<?php

namespace App\Http\Controllers;

use App\Pessoa;
use Illuminate\Http\Request;
use QRCode;

class CrachaController extends Controller
{

	public function generateQrCode($id){
		return QRCode::text($id)
				->setMargin(1)
				->svg();
	}

	public function generateCrachas(){
		$pessoas = Pessoa::all()->whereIn('id', [1,3,85,86,430,434,87,67]);

		//return view('impressao.cracha', compact('pessoas'));

		return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			->stream('crachas.pdf');

	}

}
