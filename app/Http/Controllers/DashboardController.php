<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // app/Http/Controllers/DashboardController.php
    public function index() {
    return view('dashboard.index'); 
    // Make sure this view exists in resources/views
}
}