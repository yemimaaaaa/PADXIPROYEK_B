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
            'active' => 'login',
        ]); 
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([ 
            'email' => 'required|email', 
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate(); // Regenerate session for security
            return redirect()->intended('/dashboard'); // Redirect to dashboard
        }
    
        return back()->withErrors([
            'email' => 'Email or Password is incorrect.',
        ])->onlyInput('email');
    }    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success','Anda telah');
    }
}