<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'Admin',
            'lastname' => '-',
            'email' => 'admin@groupbwt.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'type' => 'Admin',
            'birthdate' => '1997-08-05',
            'country' => '-',
            'phone' => '-',
        ]);
    }
}
