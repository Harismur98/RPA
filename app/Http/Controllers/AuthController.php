<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth');
    }

    // Handle login logic
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->remember)) {
            // If successful, redirect to intended page or dashboard
            return redirect()->intended('/dashboard');
        }

        // If unsuccessful, redirect back with input
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    // Handle logout logic
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect('/');
    }
}
