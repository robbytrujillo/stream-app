<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie; // tambahkan models movie

class DashboardController extends Controller
{
    public function index() {
        // panggil data movie
        $movies = Movie::orderBy('featured', 'DESC')
                  ->orderBy('created_at', 'DESC')
                  ->get();

        return view('member.dashboard', ['movies' => $movies]); // parse data movies
    }
}
