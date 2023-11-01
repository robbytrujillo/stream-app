<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages'); // package_id sebagai foreignId yang mengarah ke table packages
            $table->foreignId('user_id')->constrained('users'); // user_id sebagai foreignId yang mengarah ke table users
            $table->float('amount'); // total transaksi user
            $table->string('transaction_code');
            $table->string('status'); // untuk menyimpan status dari sebuah transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
