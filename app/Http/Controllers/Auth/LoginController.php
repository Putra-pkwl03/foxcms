<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Map 'username' input to 'email' column for authentication
        // or check if input is email-like.
        // Assuming we store 'admin' in the name or email column.
        // Let's try to authenticate against 'email' being the username
        // or 'name' being the username.
        
        $loginType = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        // If the user wants to login with 'admin', we'll check the 'name' column or 'email' column
        // depending on how we seed it. The migration has 'name' and 'email'.
        // Standard user model uses email for auth usually.
        // Let's force check 'name' or 'email'.
        
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password]) ||
            Auth::attempt(['name' => $request->username, 'password' => $request->password])) {
            
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
