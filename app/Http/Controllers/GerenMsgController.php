<?php

use App\Http\Controllers\Controller;

class GerenMsgController extends Controller {
    public function index() {
        return view('admin.gerenMsg.email');
    }
}