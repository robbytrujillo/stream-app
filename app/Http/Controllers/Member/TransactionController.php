<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Package;
use App\Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function store(Request $request) {
        dd($request->all());
        return "test";
    }
}
