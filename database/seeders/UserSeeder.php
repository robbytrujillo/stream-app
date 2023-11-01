<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // memanggil untuk insert ke db
use Illuminate\Support\Facades\Hash; // melakukan enkripsi terhadap password

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('mantapjasa'),
            'phone_number' => '081123456789',
            'avatar' => '',
            'role' => 'admin',
            'created_at' => now(), // mengisi timestamp waktu sekarang
            'updated_at' => now(),
        ]);
    }
}
