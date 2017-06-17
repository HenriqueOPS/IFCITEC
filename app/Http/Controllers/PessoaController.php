<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MoodleAuthService;
use App\Exceptions\MoodleErrorException;
use App\Escola;
use App\Projeto;
use App\Pessoa;

class PessoaController extends Controller {

    private $moodleService;

    public function __construct(MoodleAuthService $moodleService) {
        $this->moodleService = $moodleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
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

    public function autenticar(Request $request) {
        // TODO: Implementar acesso de parametros via Request
        try {
            $user = $this->moodleService->autenticar($escola, $request);
            dd($user);
        } catch (MoodleErrorException $e) {
            dd($e->message);
        }
    }

}
