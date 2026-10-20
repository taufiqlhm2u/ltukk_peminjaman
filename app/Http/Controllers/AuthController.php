<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }
    public function verif(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $remember = $request->remember;

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect()->route('dashboard')->with('success', 'Selamat datang kembali, '. Auth::user()->name);
        } else {
            return back()->with('error', 'Email atau password tidak sesuai.');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
