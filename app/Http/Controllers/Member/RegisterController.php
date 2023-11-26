<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $isEmailExist = User::where('email', $request->email)->exists();
        
        if ($isEmailExist) {
            return back()->withErrors([
                'email' => "This Email Already Exist"
            ])->withInput();
        }
        $data['role'] = 'member';
        $data['password'] = Hash::make($request->password);

        User::create($data);

        return back();

        //return redirect()->route('member.login');
        }
    }

