<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|string|min:6',
        ]);

        $user = User::query()->create($data);
        if ($user) {
            auth()->login($user);
            return to_route('home')->withMessage('You are successfully registered and logged in');
        }
        return back()->withMessage('Something went wrong')->withInput();
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->withMessage('You are now logged in');
        }
        return back()->withMessage('These credentials does not match')->withInput();
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('home')->withMessage('You are logged out');
    }
}
