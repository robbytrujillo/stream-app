<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\UserPremium;
use Illuminate\Support\Carbon;  

class MovieController extends Controller
{
    public function show($id) {
        $movie = Movie::find($id);
        
        // lempar data ke view
        return view('member.movie-detail', ['movie' => $movie]); // parsing data
    }

    //12122023
    public function watch($id) {
        $userId = auth()->user()->id;

        $userPremium = UserPremium::where('user_id', $userId)->first();

        if ($userPremium) {
            $endOfSubscription = $userPremium->end_of_subscription;
            $date = Carbon::createFromFormat();
        }
    }
}
