<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() {
        return view('member.register');
    }

    // function process
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // mengambil data
        $data = $request->except('_token');

        // cek email
        if ($this->checkEmail($data['email'])) {
        
        }
    }
}
