<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handler(Request $request) {
        require_once(dirname(__FILE__) . '/Midtrans.php');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$serverKey = '<your serverkey>';
        $notif = new \Midtrans\Notification();
    }
}
