<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerenMsgController extends Controller
{
    public function index() {
        return view('admin.gerenMsg.email');
    }
}
