<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]); 
    }

    public function authenticate(Request $request)
{
    $credentials = $request->validate([ 
        'username' => 'required', 
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)){
        $request->session()->regenerate(); // Regenerate session untuk mencegah session fixation
        return redirect()->intended('/dashboard'); // Redirect ke dashboard
    }

    return back()->withErrors([
        'username' => 'Username atau Password Salah.',
    ])->onlyInput('username');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect ('/login');
    }
}