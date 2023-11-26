<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {
        return view('member.auth');
    }

    // function login
    public function auth(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        
        // login is member
        $credentials['role'] = 'member';

        if (Auth::attempt($credentials)) {
            // regenerate session
            $request->session()->regenerate();

            return 'success';
            // return redirect()->route('member.dashboard');
        }
    }

    // function logout
    public function logout() {

    }
}
