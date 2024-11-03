<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CekMemberController extends Controller
{
    public function index()
    {
        return view ('cekmember.index');
    }
}