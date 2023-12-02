<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PricingController extends Controller
{

    public function index() {
        $standardPackage = Package::where('name', 'standard')->first();
        $goldPackage = Package::where('name', 'gold')->first();

        // back to view
        return view('member.pricing', [
            'standard' => $standardPackage,
            'gold' => $goldPackage
        ]);
    }
    
}
