<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class demoController extends Controller
{
    function data(Request $req)
    {
        return $req->input();
    }
}
