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
        // dd($request->all());
        // return "test";




        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
composer require midtrans/midtrans-php
                              
Alternatively, if you are not using **Composer**, you can download midtrans-php library 
(https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
the file manually.   

require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

$package = Package::find($request->package_id);

$customer = auth()->user();

$transaction = Transaction::create([
    'package_id' => $package->id,
    'user_id' => $customer->id,
    'amount' => $package->price,
    'transaction_code' => strtoupper(Str::random(10)),
    'status' => 'pending'

]
);

//SAMPLE REQUEST START HERE

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = (bool) env('MIDTRANS_IS_SANITAZED');
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = (bool) env('MIDTRANS_IS_3DS');

$params = array(
    'transaction_details' => array(
        'order_id' => $transaction->transaction_code,
        'gross_amount' => $transaction_amount,
    ),
    'customer_details' => array(
        'first_name' => $customer->name,
        'last_name' => $customer->name,
        'email' => $customer->email,
        //'phone' => '08111222333',
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
    }
}
