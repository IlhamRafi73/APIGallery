<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;


class LoginRegisterAuthController extends Controller
{
    public function _construct()
    {
        $this->middleware('guest')->except(['logout', 'dashboard']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password)
        ]);

        $content = [
            'subject' => $request->name,
            'body' => $request->email 
        ];
        
        Mail::to($request->email)->send(new SendEmail($content));

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->withSuccess('You have successfully registered & logged in!');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate
        (['email' => 'required|email', 
        'password' => 'required']);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->withSuccess('You have successfully logged in!');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('auth.dashboard');
        }
        return redirect()->route('login')
        ->withError(['email' => 'Please login first.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess('You have successfully logged out!');
    }

}