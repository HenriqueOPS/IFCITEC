<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nivel;
use Illuminate\Support\Facades\DB;

class NivelController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('cadastroNivel');
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
        //
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

    /**
     * Retrieve Areas do Conhecimento related to a Nivel
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function areasConhecimento($id) {
        $nivel = Nivel::find($id);
        if(!($nivel instanceof Nivel)){
            abort(404);
        }
        $areasConhecimento = DB::table('area_conhecimento')->select('area_conhecimento','id')->where('nivel_id', $nivel->id)->get();
        return response()->json($areasConhecimento, 200);
    }

}
