<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
// use App\Models\Role;

class TransactionController extends Controller
{
    public function index() {
        $transactions = Transaction::with([
            'package',
            'user',
        ])->get();
        // dd($transactions);
        return view('admin.transactions', ['transactions' => $transactions]);
    }
}
