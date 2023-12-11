<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Package;
use App\Models\UserPremium;
use Illuminate\Support\Carbon; //library carbon (09122023)


class WebhookController extends Controller
{
    public function handler(Request $request) {
        //require_once(dirname(__FILE__) . '/Midtrans.php');
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        $notif = new \Midtrans\Notification();
        
        $transactionStatus = $notif->transaction_status;
        $transactionCode = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        $status = '';

        // take the settings from nodejs
        if ($transactionStatus == 'capture'){
            if ($fraudStatus == 'chalange'){
                    $status = 'chalange';
                } else if ($fraudStatus == 'accept'){
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement'){
                $status = 'success';
            } else if ($transactionStatus == 'cancel' ||
              $transactionStatus == 'deny' ||
              $transactionStatus == 'expire'){
              $status = 'failure';
            } else if ($transactionStatus == 'pending'){
              $status = 'pending';
            }

            $transaction = Transaction::with('package')
              ->where('transaction_code', $transactionCode)
              ->first();

              if ($status === 'success') {
                $userPremium = UserPremium::where('user_id', $transaction->user_id)->first();

                if ($userPremium) {
                  // renewal subscription
                  $endOfSubscription = $userPremium->end_of_subscription;
                  $date = Carbon::createFromFormat('Y-m-d', $endOfSubscription);
                  $newEndOfSubscription = $date->addDays($transaction->package->max_days)->format('Y-m-d');

                  $userPremium->update([
                    'package_id' => $transaction->package_id,
                    'end_of_subscription' => $newEndOfSubscription
                  ]);
                } else {
                  UserPremium::create([
                    // new subscription
                    'package_id' => $transaction->package->id,
                    'user_id' => $transaction->user_id,
                    'end_of_subscription' =>now()->addDays($transaction->package->max_days)
                ]);
                }
              }
              $transaction->update(['status' => $status]);

              return response()->json(null);
    }
}
