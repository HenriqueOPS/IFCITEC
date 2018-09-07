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
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

	public function generateCrachasAutores(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

	public function generateComissaoAvaliadora(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

	public function generateComissaoOrganizadora(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

	public function generateCrachasOrientadores(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

	public function generateCrachasCoorientadores(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

	public function generateCrachasVoluntários(){
		$pessoas = Pessoa::all();

		return view('impressao.cracha', compact('pessoas'));

		//return \PDF::loadView('impressao.cracha', compact('pessoas'))
			// Se quiser que fique no formato a4 retrato: ->setPaper('a4', 'landscape')
			//->stream('crachas.pdf');

	}

}
