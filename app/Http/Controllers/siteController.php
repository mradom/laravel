<?php

namespace Bioteg\Http\Controllers;

use Illuminate\Http\Request;

use Bioteg\Http\Requests;

class siteController extends Controller
{
    public function index(){
		return response()->json(['ok' => 'Api Working.'], 200);
    }
}
