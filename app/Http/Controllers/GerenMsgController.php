<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerenMsgController extends Controller
{
    public function index() {
        return view('admin.gerenMsg.email');
    }

    public function fetch(string $dataType) {
        switch($dataType) {
            case 'email':
                return response('email');
                break;
            case 'aviso': 
                return response('avisos');
        }
    }

    public function save(string $dataType) {

    }

    public function delete(string $dataType) {

    }

    public function update(string $dataType) {

    }
}
