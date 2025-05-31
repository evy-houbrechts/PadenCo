<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{ //pagina registreren
    public function showRegisterForm()
    {

        return view('auth.register');
    }
    //registreren
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $credentials['password'] = Hash::make($credentials['password']);
    
        $user = User::create($credentials);
        Auth::login($user); 
    
        return redirect()->intended(route('home'));
    }
 //pagina in te loggen
    public function showLoginForm()
    {
        return view('auth.login');
    }
   //inloggen
    public function login(LoginRequest $request)
{
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); 
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'login' => 'De combinatie van e-mail en wachtwoord is ongeldig.',
        ]);
    }
    //uitloggen
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}